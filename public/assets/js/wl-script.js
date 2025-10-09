document.addEventListener("DOMContentLoaded", function () {
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
                const res = await fetch("https://api.ipify.org?format=json");
                const data = await res.json();
                return data.ip;
            } catch (e) {
                console.error("Unable to fetch public IP", e);
                return null;
            }
        }
        form.addEventListener("submit", async function () {
            const currentScript = getCurrentScript();
            const token = getScriptToken(currentScript);
            const apiBaseUrl = getApiBaseUrl(currentScript);
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
            const payload = JSON.stringify({
                visitor_id,
                script_token: token,
                form_data: formData,
                device_info: deviceInfo
            });
            try {
                // 🟢 1️⃣ Try with fetch first
                console.log("Submitting via fetch:", `${apiBaseUrl}/brand-leads`);
                const res = await fetch(`${apiBaseUrl}/brand-leads`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: payload
                });

                let data = null;
                try {
                    data = await res.json();
                } catch (jsonErr) {
                    console.warn("Response is not valid JSON:", jsonErr);
                }

                if (!res.ok) throw new Error("Fetch request failed: " + res.statusText);

                console.log("Lead submission response (fetch):", data || res.statusText);

                localStorage.setItem(
                    "leadSubmissionResponse_" + apiBaseUrl,
                    JSON.stringify({
                        method: "fetch",
                        status: res.status,
                        data: data || null,
                        success: true,
                        timestamp: new Date().toISOString()
                    })
                );

            } catch (err) {
                // 🔴 If fetch fails → fallback to sendBeacon
                console.warn("Fetch failed, falling back to Beacon:", err);

                try {
                    const blob = new Blob([payload], { type: "application/json" });
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
            }
        });
    });
});
