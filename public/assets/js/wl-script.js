document.addEventListener("DOMContentLoaded", function () {
    let currentScript = document.currentScript;
    if (!currentScript) {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        currentScript = scripts[scripts.length - 1] || null;
    }

    if (!currentScript) {
        console.error("Script tag not found!");
        return;
    }

    const url = new URL(currentScript.src);
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

    function getVisitorId() {
        let id = localStorage.getItem("visitor_id");
        if (!id) {
            id = "v_" + Math.random().toString(36).substr(2, 9) + Date.now();
            localStorage.setItem("visitor_id", id);
        }
        return id;
    }

    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        const visitor_id = getVisitorId();
        async function getPublicIP() {
            try {
                const res = await fetch("https://api.ipify.org?format=json");
                const data = await res.json();
                return data.ip;
            } catch (e) {
                console.error("Unable to fetch public IP", e);
                return null;
            }
        }
        form.addEventListener("submit", async function () {
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


            const publicIP = await getPublicIP();
            if (publicIP) {
                deviceInfo.public_ip = publicIP;
            }


            fetch(`${apiBaseUrl}/brand-leads`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    visitor_id,
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
