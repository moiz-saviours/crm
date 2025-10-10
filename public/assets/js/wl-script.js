document.addEventListener("DOMContentLoaded", function () {
    let currentScript = getCurrentScript();
    let token = getScriptToken(currentScript);
    let apiBaseUrl = getApiBaseUrl(currentScript);
    function getCurrentScript() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        for (let script of scripts) {
            if (!script.hasAttribute('data-wl-processed')) {
                script.setAttribute('data-wl-processed', 'true');
                script.setAttribute('crossorigin', 'anonymous');
                return script;
            }
        }
        return scripts[scripts.length - 1] || null;
    }
    function getScriptToken(currentScript) {
        if (!currentScript) {
            console.error("Script tag not found!");
            return null;
        }
        const url = new URL(currentScript.src);
        const token = url.searchParams.get("token");

        if (!token) {
            console.error("Brand token missing in script URL!");
            return null;
        }

        return token;
    }
    function getApiBaseUrl(currentScript) {
        if (!currentScript) {
            console.error("Script tag not found!");
            return null;
        }

        const url = new URL(currentScript.src);
        let apiBaseUrl = "";
        const hostname = url.hostname;
        const scriptPath = url.pathname;

        if (hostname === 'localhost' || hostname === '127.0.0.1') {
            apiBaseUrl = url.origin + "/api";
            console.log("Environment: Local");
        } else if (scriptPath.includes("/crm-development/")) {
            apiBaseUrl = url.origin + "/crm-development/api";
            console.log("Environment: Development (path-based)");
        } else {
            apiBaseUrl = url.origin + "/api";
            console.log("Environment: Live");
        }

        console.log("Using API base URL:", apiBaseUrl);
        return apiBaseUrl;
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
                const res = await fetch("https://ipapi.co/json");
                return await res.json();
            } catch (e) {
                console.error("Unable to fetch public IP", e);
                return null;
            }
        }
        form.addEventListener("submit", async function () {
            currentScript = getCurrentScript();
            token = getScriptToken(currentScript);
            apiBaseUrl = getApiBaseUrl(currentScript);
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
            let publicData;
            try {
                publicData = await getPublicIP();
            } catch (e) {
                publicData = null;
            }
            if (publicData) {
                deviceInfo.public_ip = publicData.ip;
                deviceInfo.publicData = publicData;
            }
            const payload = JSON.stringify({
                visitor_id,
                script_token: token,
                form_data: formData,
                device_info: deviceInfo
            });
            try {
                const blob = new Blob([payload], {type: "application/json"});
                const beaconSuccess = navigator.sendBeacon(`${apiBaseUrl}/brand-leads`, blob);

                if (beaconSuccess) {
                    console.log("Lead submission sent successfully using Beacon:", `${apiBaseUrl}/brand-leads`);
                    localStorage.setItem(
                        "leadSubmissionResponse_" + apiBaseUrl,
                        JSON.stringify({
                            method: "beacon",
                            success: true,
                            timestamp: new Date().toISOString()
                        })
                    );
                } else {
                    console.error("Beacon failed to send data");
                    localStorage.setItem(
                        "leadSubmissionResponse_" + apiBaseUrl,
                        JSON.stringify({
                            method: "beacon",
                            success: false,
                            error: "Beacon send failed",
                            timestamp: new Date().toISOString()
                        })
                    );
                }
            } catch (beaconErr) {
                console.error("Beacon fallback also failed:", beaconErr);
                localStorage.setItem(
                    "leadSubmissionResponse_" + apiBaseUrl,
                    JSON.stringify({
                        method: "beacon",
                        success: false,
                        error: beaconErr.message,
                        timestamp: new Date().toISOString()
                    })
                );
            }
        });
    });
});
