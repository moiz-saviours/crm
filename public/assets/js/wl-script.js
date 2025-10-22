// document.addEventListener("DOMContentLoaded", function () {
//
//     function getAllWlScripts() {
//         return Array.from(document.querySelectorAll('script[src*="wl-script.js"]'));
//     }
//
//     function getScriptToken(script) {
//         const url = new URL(script.src);
//         const token = url.searchParams.get("token");
//         return token || null;
//     }
//
//     function getApiBaseUrl(script) {
//         const url = new URL(script.src);
//         const hostname = url.hostname;
//         const path = url.pathname;
//         if (hostname === 'localhost' || hostname === '127.0.0.1') {
//             return url.origin + "/api";
//         } else if (path.includes("/crm-development/")) {
//             return url.origin + "/crm-development/api";
//         } else {
//             return url.origin + "/api";
//         }
//     }
//
//     function getVisitorId() {
//         let id = localStorage.getItem("visitor_id");
//         if (!id) {
//             id = "v_" + Math.random().toString(36).substr(2, 9) + Date.now();
//             localStorage.setItem("visitor_id", id);
//         }
//         return id;
//     }
//
//     const forms = document.querySelectorAll("form");
//
//     forms.forEach(form => {
//         form.addEventListener("submit", async function (e) {
//             if (form.dataset.submitted === "true") return;
//             form.dataset.submitted = "true";
//             const visitor_id = getVisitorId();
//             const formData = {};
//             const fields = form.querySelectorAll("label, input, textarea, select");
//
//             fields.forEach((field, index) => {
//                 if (field.name) {
//                     formData[field.name] = field.value;
//                 } else {
//                     formData["field_" + index] = field.value;
//                 }
//             });
//
//             const deviceInfo = {
//                 url: window.location.href,
//                 title: document.title,
//                 referrer: document.referrer || null,
//                 platform: navigator.platform,
//                 language: navigator.language,
//                 cookies_enabled: navigator.cookieEnabled,
//                 screen_resolution: `${window.screen.width}x${window.screen.height}`,
//                 window_size: `${window.innerWidth}x${window.innerHeight}`,
//                 timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
//                 submission_time: new Date().toLocaleString()
//             };
//
//             const payload = JSON.stringify({
//                 visitor_id,
//                 form_data: formData,
//                 device_info: deviceInfo
//             });
//
//             // ✅ Send to all CRM scripts
//             const wlScripts = getAllWlScripts();
//             wlScripts.forEach(script => {
//                 const token = getScriptToken(script);
//                 const apiBaseUrl = getApiBaseUrl(script);
//                 if (!token || !apiBaseUrl) return;
//
//                 const finalPayload = JSON.stringify({
//                     visitor_id,
//                     script_token: token,
//                     form_data: formData,
//                     device_info: deviceInfo
//                 });
//
//                 try {
//                     const blob = new Blob([finalPayload], { type: "application/json" });
//                     const beaconSuccess = navigator.sendBeacon(`${apiBaseUrl}/brand-leads`, blob);
//
//                     console.log(
//                         beaconSuccess
//                             ? ` Lead sent successfully to ${apiBaseUrl}`
//                             : ` Beacon failed for ${apiBaseUrl}`
//                     );
//                 } catch (err) {
//                     console.error("Error sending to:", apiBaseUrl, err);
//                 }
//             });
//         });
//     });
// });



// my updated

document.addEventListener("DOMContentLoaded", function () {
    const PENDING_SUBMISSIONS_KEY = "pending_lead_submissions";
    const SUBMITTED_IDS_KEY = "submitted_lead_ids";

    // ✅ NEW: detect all wl-script instances
    const allScriptInfos = Array.from(document.querySelectorAll('script[src*="wl-script.js"]')).map(script => {
        const url = new URL(script.src);
        const token = url.searchParams.get("token");
        const domain = getApiBaseUrl(script);
        return { script, src: script.src, token, domain };
    });

    if (allScriptInfos.length > 0) {
        console.log("WL Script: Multiple active instances found:");
        allScriptInfos.forEach(info => {
            console.log(` → ${info.src} | Token: ${info.token} | Domain: ${info.domain}`);
        });
    } else {
        console.warn("No wl-script instances found on page!");
    }

    /* ------------------------------------------------
       Helper: get API base URL (kept from your code)
    ------------------------------------------------ */
    function getApiBaseUrl(currentScript) {
        if (!currentScript) return null;

        try {
            const url = new URL(currentScript.src);
            const hostname = url.hostname;
            const scriptPath = url.pathname;
            let apiBaseUrl = "";

            if (hostname === "localhost" || hostname === "127.0.0.1") {
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
        } catch (e) {
            console.error("Error computing api base url:", e);
            return null;
        }
    }

    /* -------------------------
       Visitor + Form Handlers
    ------------------------- */
    function getVisitorId() {
        let id = localStorage.getItem("visitor_id");
        if (!id) {
            id = "v_" + Math.random().toString(36).substr(2, 9) + Date.now();
            localStorage.setItem("visitor_id", id);
        }
        return id;
    }

    function generateSubmissionId() {
        return "sub_" + Math.random().toString(36).substr(2, 9) + Date.now();
    }

    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        const visitor_id = getVisitorId();

        form.addEventListener("submit", function () {
            const formData = {};
            const fields = form.querySelectorAll("input, textarea, select");
            fields.forEach((field, index) => {
                if (field.disabled || field.type === "file") return;
                const name = field.name || field.getAttribute("data-label") || `field_${index}`;
                formData[name] = field.value || "";
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

            const submissionObj = {
                visitor_id,
                script_token: "pending", // token will be attached later per domain
                form_data: formData,
                device_info: deviceInfo
            };

            saveSubmissionToStorage(submissionObj);
            console.log("Form data saved locally, will send to all CRM domains.");
        });
    });

    /* -------------------------
       Storage helpers
    ------------------------- */
    function getPendingSubmissions() {
        try {
            const pending = localStorage.getItem(PENDING_SUBMISSIONS_KEY);
            return pending ? JSON.parse(pending) : [];
        } catch {
            return [];
        }
    }

    function saveSubmissionToStorage(submission) {
        const pending = getPendingSubmissions();
        submission.id = submission.id || generateSubmissionId();
        submission.createdAt = submission.createdAt || new Date().toISOString();
        pending.push(submission);
        localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(pending));
        console.log("Saved to localStorage:", submission.id);
        return submission.id;
    }

    function getSubmittedIds() {
        try {
            const submitted = localStorage.getItem(SUBMITTED_IDS_KEY);
            return submitted ? JSON.parse(submitted) : {};
        } catch {
            return {};
        }
    }

    function markSubmissionAsSent(submissionId, domain) {
        const submitted = getSubmittedIds();
        submitted[`${submissionId}_${domain}`] = new Date().toISOString();
        localStorage.setItem(SUBMITTED_IDS_KEY, JSON.stringify(submitted));
    }

    function isSubmissionSent(submissionId, domain) {
        const submitted = getSubmittedIds();
        return !!submitted[`${submissionId}_${domain}`];
    }

    /* -------------------------
       Network
    ------------------------- */
    async function sendToSingleDomain(domain, submission) {
        try {
            const resp = await fetch(`${domain}/brand-leads`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(submission)
            });
            const text = await resp.text();
            localStorage.setItem(`${domain}_${submission.id}`, text);
            if (resp.ok) {
                console.log(`✅ Sent ${submission.id} to ${domain}`);
                return true;
            } else {
                console.error(`❌ Failed for ${domain}: ${resp.status}`);
                return false;
            }
        } catch (e) {
            console.error(`Error sending to ${domain}:`, e);
            return false;
        }
    }

    /* -------------------------
       Sending pending submissions
    ------------------------- */
    async function sendStoredSubmissions() {
        const pending = getPendingSubmissions();
        if (pending.length === 0) return;

        console.log(`Found ${pending.length} pending submissions`);

        // ✅ use all script infos instead of getAllUniqueDomains()
        const workingDomains = allScriptInfos.map(info => info.domain);

        for (const submission of pending) {
            for (const instance of allScriptInfos) {
                if (isSubmissionSent(submission.id, instance.domain)) continue;

                // ✅ attach correct token per domain
                const finalPayload = {
                    ...submission,
                    script_token: instance.token,
                    source: instance.src
                };

                const success = await sendToSingleDomain(instance.domain, finalPayload);
                if (success) markSubmissionAsSent(submission.id, instance.domain);

                await new Promise(r => setTimeout(r, 300));
            }
        }
    }

    /* -------------------------
       Cleanup + Triggers
    ------------------------- */
    function cleanupOldSubmissions() {
        const pending = getPendingSubmissions();
        const recent = pending.filter(sub => {
            const date = new Date(sub.createdAt);
            return date > new Date(Date.now() - 24 * 60 * 60 * 1000);
        });
        localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(recent));
    }

    setTimeout(() => {
        cleanupOldSubmissions();
        sendStoredSubmissions();
    }, 2000);

    document.addEventListener("visibilitychange", function () {
        if (!document.hidden) sendStoredSubmissions();
    });
});

