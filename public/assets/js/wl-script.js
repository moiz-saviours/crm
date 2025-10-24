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
    if (window.__wlScriptRunning) {
        console.log('WL Script: Another instance is already running, skipping this script');
        return;
    }
    const DEBUG_KEY = "debug_mode";

    if (!localStorage.getItem(DEBUG_KEY)) {
        localStorage.setItem(DEBUG_KEY, "true");
    }
    const DEBUG_MODE = localStorage.getItem(DEBUG_KEY) === "true";
    console.log("🪶 Debug Mode:", DEBUG_MODE ? "ON" : "OFF");

    const PENDING_SUBMISSIONS_KEY = "pending_lead_submissions";
    const SUBMITTED_IDS_KEY = "submitted_lead_ids";
    const activeScriptInfo = getActiveScriptInfo();
    if (activeScriptInfo) {
        console.log('WL Script: Active instance running from:', activeScriptInfo.src);
        const allScripts = document.querySelectorAll('script[src*="wl-script.js"]');
        allScripts.forEach(script => script.setAttribute('data-wl-processed', 'true'));
    }
    function getActiveScriptInfo() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        let activeScript = null;
        for (let script of scripts) {
            if (!script.hasAttribute('data-wl-processed')) {
                activeScript = script;
                break;
            }
        }
        if (!activeScript && scripts.length > 0) {
            activeScript = scripts[0];
        }
        if (activeScript) {
            return {
                full_url: activeScript.src,
                script: activeScript,
                domain: getApiBaseUrl(activeScript),
                src: activeScript.src,
                token: getScriptToken(activeScript)
            };
        }
        return null;
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
    function getDomainTokenMap() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        const map = {};
        scripts.forEach(script => {
            const domain = getApiBaseUrl(script);
            const token = getScriptToken(script);
            if (domain && token) map[domain] = token;
        });
        console.log("🌐 Domain–Token Map:", map);
        return map;
    }

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
    const visitor_id = !localStorage.getItem("visitor_id") ? getVisitorId() : localStorage.getItem("visitor_id");
    forms.forEach(form => {
        form.addEventListener("submit", async function () {
            if (window.__wlScriptRunning) return;
            window.__wlScriptRunning = true;

            const token = activeScriptInfo ? activeScriptInfo.token : null;
            const formData = {};
            const fields = form.querySelectorAll("label, input, textarea, select");

            fields.forEach((field, index) => {
                if (field.name) formData[field.name] = field.value; else if (field.label) formData[field.label] = field.value; else formData["field_" + index] = field.value;
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
            const payload = ({
                visitor_id,
                script_token: token,
                form_data: formData,
                device_info: deviceInfo,
                scriptInstance: activeScriptInfo ? activeScriptInfo.src : 'unknown',
                id: generateSubmissionId(),
                createdAt: new Date().toISOString(),
                attemptedDomains: []
            });
            saveSubmissionToStorage(payload);
        });
    });
    function saveSubmissionToStorage(submission) {
        const pending = getPendingSubmissions();
        pending.push(submission);
        localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(pending));
    }
    function getPendingSubmissions() {
        try {
            return JSON.parse(localStorage.getItem(PENDING_SUBMISSIONS_KEY)) || [];
        } catch {
            return [];
        }
    }
    function markSubmissionAsSent(submissionId, domain) {
        const submitted = JSON.parse(localStorage.getItem(SUBMITTED_IDS_KEY)) || {};
        submitted[`${submissionId}_${domain}`] = new Date().toISOString();
        localStorage.setItem(SUBMITTED_IDS_KEY, JSON.stringify(submitted));
    }
    function isSubmissionSent(submissionId, domain) {
        const submitted = JSON.parse(localStorage.getItem(SUBMITTED_IDS_KEY)) || {};
        return !!submitted[`${submissionId}_${domain}`];
    }
    async function sendToSingleDomain(domain, submission) {
        try {
            const response = await fetch(`${domain}/brand-leads`, {
                method: 'POST', headers: {
                    'Content-Type': 'application/json',
                }, body: JSON.stringify(submission)
            });
            return response.ok;
        } catch (error) {
            return false;
        }
    }
    async function sendSubmissionToDomains(submission) {
        const domainTokenMap = getDomainTokenMap();
        let sentToAll = true;

        for (const [domain, token] of Object.entries(domainTokenMap)) {
            if (isSubmissionSent(submission.id, domain)) {
                console.log(`Skipping ${domain}, already sent.`);
                continue;
            }
            const payload = {
                visitor_id: submission.visitor_id,
                submissions: [
                    {
                        domain,
                        script_token: token,
                        form_data: submission.form_data,
                        device_info: submission.device_info,
                        scriptInstance: `${domain.replace('/api', '')}/assets/js/wl-script.js?token=${token}`,
                        id: submission.id,
                        createdAt: submission.createdAt
                    }
                ]
            };
            const success = await sendToSingleDomain(domain, payload);
            if (success) markSubmissionAsSent(submission.id, domain);
            else sentToAll = false;
            await new Promise(r => setTimeout(r, 500));
        }
        if (sentToAll) {
            console.log(`Submission ${submission.id} successfully sent to all domains, removing from storage`);
            removeSubmissionFromStorage(submission.id);
        } else {
            submission.retryCount = (submission.retryCount || 0) + 1;
            if (submission.retryCount >= 1) {
                console.warn(`⚠️ Removing submission ${submission.id} after 3 failed attempts`);
                removeSubmissionFromStorage(submission.id);
            } else {
                saveSubmissionToStorage(submission);
            }
        }
    }
    function getAllUniqueDomains() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        const domainMap = new Map();

        scripts.forEach(script => {
            try {
                const baseUrl = getApiBaseUrl(script);
                if (baseUrl) {
                    const domainKey = new URL(baseUrl).hostname;
                    if (!domainMap.has(domainKey)) {
                        domainMap.set(domainKey, baseUrl);
                    }
                }
            } catch (e) {
                console.error("Error parsing script URL:", e);
            }
        });

        const uniqueDomains = Array.from(domainMap.values());
        console.log(`Found ${uniqueDomains.length} unique domains from ${scripts.length} scripts`);
        return uniqueDomains;
    }
    async function sendStoredSubmissions() {
        const pending = getPendingSubmissions();
        if (pending.length === 0) return;
        console.log(`Found ${pending.length} pending submissions to send`);
        const workingDomains = getAllUniqueDomains();
        if (workingDomains.length === 0) {
            console.log("No domains found, keeping submissions for later");
            return;
        }
        for (const submission of pending) {
            await sendSubmissionToDomains(submission);
        }
    }
    function removeSubmissionFromStorage(submissionId) {
        try {
            const pending = getPendingSubmissions();
            const filtered = pending.filter(sub => sub.id !== submissionId);
            localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(filtered));
            console.log("Submission removed from storage:", submissionId);
        } catch (e) {
            console.error("Error removing submission from storage:", e);
        }
    }
    function cleanupOldSubmissions() {
        if (DEBUG_MODE) {
            console.log("🟡 Debug: Cleanup skipped");
            return;
        }

        const pending = getPendingSubmissions();
        const now = new Date();
        const twentyFourHoursAgo = new Date(now.getTime() - (24 * 60 * 60 * 1000));

        const recentSubmissions = pending.filter(submission => {
            const submissionDate = new Date(submission.createdAt);
            return submissionDate > twentyFourHoursAgo;
        });

        if (recentSubmissions.length !== pending.length) {
            localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(recentSubmissions));
            console.log(`Cleaned up ${pending.length - recentSubmissions.length} old submissions`);
        }
    }
    cleanupOldSubmissions();
    sendStoredSubmissions();
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && DEBUG_MODE === false) {
            sendStoredSubmissions();
        }
    });
});


