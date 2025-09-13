document.addEventListener("DOMContentLoaded", function () {
    const scriptEl = document.querySelector('script[src*="wl-script.js"]');
    if (!scriptEl) {
        console.error("Script tag not found!");
        return;
    }

    const url = new URL(scriptEl.src);
    const token = url.searchParams.get("token");

    if (!token) {
        console.error("Brand token missing in script URL!");
        return;
    }

    // const baseUrl = url.origin;
    // Environment detection
    let apiBaseUrl = "";
    if (url.pathname.includes("/crm-development/")) {
        apiBaseUrl = url.origin + "/crm-development/api"; // Development
    } else {
        apiBaseUrl = url.origin + "/api"; // Live
    }

    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        form.addEventListener("submit", function () {
            const formData = {};
            const fields = form.querySelectorAll("label, input, textarea, select");

            fields.forEach((field, index) => {
                if (field.name) {
                    formData[field.name] = field.value;
                } else if (field.label) {
                    formData[field.label] = field.value;
                } else {
                    formData["field_" + index] = field.value;
                }
            });

            const deviceInfo = {
                url: window.location.href,
                title: document.title,
                referrer: document.referrer || null,
                platform: navigator.platform,
                language: navigator.language,
                cookies_enabled: navigator.cookieEnabled,
                screen_resolution: `${window.screen.width}x${window.screen.height}`,
                window_size: `${window.innerWidth}x${window.innerHeight}`,
                timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                submission_time: new Date().toLocaleString()
            };



            fetch(`${apiBaseUrl}/brand-leads`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    script_token: token,
                    form_data: formData,
                    device_info: deviceInfo
                })
            })
                .then(res => res.json())
                .then(res => {
                    console.log("Lead submission response:", res);
                })
                .catch(err => {
                    console.error("Form submission failed", err);
                });
        });
    });
});
