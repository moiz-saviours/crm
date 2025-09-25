(function () {
    const scriptEl = document.querySelector('script[src*="user-activity.js"]');
    const apiBase = scriptEl.src.split("/assets/js/")[0];
    const startTime = Date.now();
    let maxScroll = 0;
    let clickCount = 0;

    const activityData = {
        user_in_time: new Date(startTime).toISOString(),
        url: window.location.href,
        title: document.title,
    };

    function sendActivity(sync = false) {
        const url = `${apiBase}/api/track-activity`;
        const data = JSON.stringify({
            event_type: "page_view",
            event_data: activityData
        });

        if (sync && navigator.sendBeacon) {
            const blob = new Blob([data], { type: "application/json" });
            navigator.sendBeacon(url, blob);
        } else {
            fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: data
            }).catch(() => {});
        }
    }

// Tab close ya refresh hone par
    window.addEventListener("beforeunload", function () {
        activityData.user_out_time = new Date().toISOString();
        activityData.total_duration = ((Date.now() - startTime) / 1000).toFixed(2);
        activityData.scroll_max_percent = maxScroll;
        activityData.click_count = clickCount;

        sendActivity(true);
    });


    // Track scroll depth (only update maximum)
    window.addEventListener("scroll", () => {
        const scrolled = window.scrollY + window.innerHeight;
        const height = document.documentElement.scrollHeight;
        const percent = ((scrolled / height) * 100).toFixed(2);

        if (percent > maxScroll) {
            maxScroll = percent;
        }
    });

    // Track click count
    window.addEventListener("click", () => {
        clickCount++;
    });


    // Form submissions
    document.addEventListener("submit", function (e) {
        const form = e.target;
        const formData = {};

        form.querySelectorAll("input, textarea, select").forEach(f => {
            if (f.name) formData[f.name] = f.value;
        });

        if (!activityData.form_submissions) {
            activityData.form_submissions = [];
        }

        activityData.form_submissions.push({
            form_name: form.getAttribute("name") || form.id || "unnamed_form",
            form_action: form.action,
            submitted_at: new Date().toISOString(),
            data: formData
        });
    });

})();
