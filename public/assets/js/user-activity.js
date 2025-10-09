(function () {

    function getCurrentScript() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        for (let script of scripts) {
            if (!script.hasAttribute('data-wl-processed')) {
                script.setAttribute('data-wl-processed', 'true');
                return script;
            }
        }
        return scripts[scripts.length - 1] || null;
    }
    function getApiBaseUrl(currentScript) {
        if (!currentScript) {
            console.error("Script tag not found!");
            return null;
        }

        const url = new URL(currentScript.src);
        let apiBaseUrl = "";
        const hostname = window.location.hostname;
        const scriptPath = url.pathname;

        if (hostname === 'localhost' || hostname === '127.0.0.1') {
            apiBaseUrl = url.origin + "/api";
            console.log("Environment: Local");
        }
        else if (hostname.includes('dev.') || hostname.includes('development.') || hostname.includes('staging.')) {
            apiBaseUrl = url.origin + "/crm-development/api";
            console.log("Environment: Development");
        }
        else if (scriptPath.includes("/crm-development/")) {
            apiBaseUrl = url.origin + "/crm-development/api";
            console.log("Environment: Development (path-based)");
        }
        else {
            apiBaseUrl = url.origin + "/api";
            console.log("Environment: Live");
        }

        console.log("Using API base URL:", apiBaseUrl);
        return apiBaseUrl;
    }

    const currentScript = getCurrentScript();
    const apiBaseUrl = getApiBaseUrl(currentScript);

    const startTime = Date.now();
    let maxScroll = 0;
    let clickCount = 0;

    const activityData = {
        user_in_time: new Date(startTime).toISOString(),
        url: window.location.href,
        title: document.title,
    };

    function getVisitorId() {
        let id = localStorage.getItem("visitor_id");
        if (!id) {
            id = "v_" + Math.random().toString(36).substr(2, 9) + Date.now();
            localStorage.setItem("visitor_id", id);
        }
        return id;
    }

    const visitor_id = getVisitorId();
    let publicIp = null;

    fetch("https://api.ipify.org?format=json")
        .then(res => res.json())
        .then(data => {
            publicIp = data.ip;
        })
        .catch(() => {
            publicIp = null;
        });

    function sendActivity(sync = false) {
        const endpoint = `${apiBaseUrl}/track-activity`;
        const data = JSON.stringify({
            visitor_id,
            event_type: "page_view",
            event_data: activityData,
            public_ip: publicIp
        });

        if (sync && navigator.sendBeacon) {
            const blob = new Blob([data], { type: "application/json" });
            navigator.sendBeacon(endpoint, blob);
        } else {
            fetch(endpoint, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: data
            }).catch(() => {});
        }
    }

    // Tab close or refresh hone par
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
