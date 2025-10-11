// document.addEventListener("DOMContentLoaded", function () {
//     function getCurrentScript() {
//         const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
//         for (let script of scripts) {
//             if (!script.hasAttribute('data-wl-processed')) {
//                 script.setAttribute('data-wl-processed', 'true');
//                 script.setAttribute('crossorigin', 'anonymous');
//                 return script;
//             }
//         }
//         return scripts[scripts.length - 1] || null;
//     }
//     function getScriptToken(currentScript) {
//         if (!currentScript) {
//             console.error("Script tag not found!");
//             return null;
//         }
//         const url = new URL(currentScript.src);
//         const token = url.searchParams.get("token");
//
//         if (!token) {
//             console.error("Brand token missing in script URL!");
//             return null;
//         }
//
//         return token;
//     }
//     function getApiBaseUrl(currentScript) {
//         if (!currentScript) {
//             console.error("Script tag not found!");
//             return null;
//         }
//
//         const url = new URL(currentScript.src);
//         let apiBaseUrl = "";
//         const hostname = url.hostname;
//         const scriptPath = url.pathname;
//
//         if (hostname === 'localhost' || hostname === '127.0.0.1') {
//             apiBaseUrl = url.origin + "/api";
//             console.log("Environment: Local");
//         } else if (scriptPath.includes("/crm-development/")) {
//             apiBaseUrl = url.origin + "/crm-development/api";
//             console.log("Environment: Development (path-based)");
//         } else {
//             apiBaseUrl = url.origin + "/api";
//             console.log("Environment: Live");
//         }
//
//         console.log("Using API base URL:", apiBaseUrl);
//         return apiBaseUrl;
//     }
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
//         const visitor_id = getVisitorId();
//         form.addEventListener("submit", async function () {
//             currentScript = getCurrentScript();
//             token = getScriptToken(currentScript);
//             apiBaseUrl = getApiBaseUrl(currentScript);
//             const formData = {};
//             const fields = form.querySelectorAll("label, input, textarea, select");
//
//             fields.forEach((field, index) => {
//                 if (field.name) {
//                     formData[field.name] = field.value;
//                 } else if (field.label) {
//                     formData[field.label] = field.value;
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
//             const payload = JSON.stringify({
//                 visitor_id,
//                 script_token: token,
//                 form_data: formData,
//                 device_info: deviceInfo
//             });
//             try {
//                 const blob = new Blob([payload], {type: "application/json"});
//                 const beaconSuccess = navigator.sendBeacon(`${apiBaseUrl}/brand-leads`, blob);
//
//                 if (beaconSuccess) {
//                     console.log("Lead submission sent successfully using Beacon:", `${apiBaseUrl}/brand-leads`);
//                     localStorage.setItem(
//                         "leadSubmissionResponse_" + apiBaseUrl,
//                         JSON.stringify({
//                             method: "beacon",
//                             success: true,
//                             timestamp: new Date().toISOString()
//                         })
//                     );
//                 } else {
//                     console.error("Beacon failed to send data");
//                     localStorage.setItem(
//                         "leadSubmissionResponse_" + apiBaseUrl,
//                         JSON.stringify({
//                             method: "beacon",
//                             success: false,
//                             error: "Beacon send failed",
//                             timestamp: new Date().toISOString()
//                         })
//                     );
//                 }
//             } catch (beaconErr) {
//                 console.error("Beacon fallback also failed:", beaconErr);
//                 localStorage.setItem(
//                     "leadSubmissionResponse_" + apiBaseUrl,
//                     JSON.stringify({
//                         method: "beacon",
//                         success: false,
//                         error: beaconErr.message,
//                         timestamp: new Date().toISOString()
//                     })
//                 );
//             }
//         });
//     });
// });
document.addEventListener("DOMContentLoaded", function () {
    const PENDING_SUBMISSIONS_KEY = "pending_lead_submissions";
    const SUBMITTED_IDS_KEY = "submitted_lead_ids";
    const activeScriptInfo = getActiveScriptInfo();
    if (activeScriptInfo) {
        console.log('WL Script: Active instance running from:', activeScriptInfo.src);
        const allScripts = document.querySelectorAll('script[src*="wl-script.js"]');
        allScripts.forEach(script => {
            script.setAttribute('data-wl-processed', 'true');
        });
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
            const url = new URL(activeScript.src);
            return {
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
        form.addEventListener("submit", async function () {
            if (window.__wlScriptRunning) {
                console.log('WL Script: Another instance is already running, skipping this script');
                return;
            }
            window.__wlScriptRunning = true;

            const token = activeScriptInfo ? activeScriptInfo.token : null;
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
            const payload = JSON.stringify({
                visitor_id,
                script_token: token,
                form_data: formData,
                device_info: deviceInfo,
                scriptInstance: activeScriptInfo ? activeScriptInfo.src : 'unknown'
            });
            saveSubmissionToStorage(payload);
            console.log("Form data saved to localStorage, will send to unique domains after redirect");
        });
    });
    function saveSubmissionToStorage(submission) {
        try {
            const pending = getPendingSubmissions();
            submission.id = submission.id || generateSubmissionId();
            submission.createdAt = new Date().toISOString();
            submission.attemptedDomains = submission.attemptedDomains || [];

            pending.push(submission);
            localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(pending));
            console.log("Submission saved to storage:", submission.id);
            return submission.id;
        } catch (e) {
            console.error("Error saving submission to storage:", e);
            return null;
        }
    }
    async function sendToSingleDomain(domain, submission) {
        try {
            const response = await fetch(`${domain}/brand-leads`, {
                method: 'POST', headers: {
                    'Content-Type': 'application/json',
                }, body: JSON.stringify(submission)
            });

            if (response.ok) {
                console.log(`Successfully sent submission ${submission.id} to ${domain}`);
                return true;
            } else {
                console.error(`Fetch failed for ${domain}: HTTP ${response.status}`);
                return false;
            }
        } catch (error) {
            console.error(`Error sending to ${domain}:`, error);
            return false;
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
            await sendSubmissionToDomains(submission, workingDomains);
            await new Promise(resolve => setTimeout(resolve, 500));
        }
    }
    async function sendSubmissionToDomains(submission, domains) {
        const results = [];
        let sentToAllDomains = true;

        for (const domain of domains) {
            if (isSubmissionSent(submission.id, domain)) {
                console.log(`Submission ${submission.id} already sent to ${domain}, skipping`);
                continue;
            }

            const success = await sendToSingleDomain(domain, submission);
            results.push({domain, success});
            if (success) {
                markSubmissionAsSent(submission.id, domain);
            } else {
                sentToAllDomains = false;
            }
        }
        if (sentToAllDomains) {
            console.log(`Submission ${submission.id} successfully sent to all domains, removing from storage`);
            removeSubmissionFromStorage(submission.id);
        } else {
            submission.attemptedDomains = domains.filter(domain => results.find(r => r.domain === domain && r.success));
            const pending = getPendingSubmissions();
            const index = pending.findIndex(sub => sub.id === submission.id);
            if (index !== -1) {
                pending[index] = submission;
                localStorage.setItem(PENDING_SUBMISSIONS_KEY, JSON.stringify(pending));
            }
            console.log(`Submission ${submission.id} sent to ${submission.attemptedDomains.length} out of ${domains.length} domains`);
        }
        return results;
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
    function markSubmissionAsSent(submissionId, domain) {
        try {
            const submitted = getSubmittedIds();
            const key = `${submissionId}_${domain}`;
            submitted[key] = new Date().toISOString();
            localStorage.setItem(SUBMITTED_IDS_KEY, JSON.stringify(submitted));
        } catch (e) {
            console.error("Error marking submission as sent:", e);
        }
    }
    function getSubmittedIds() {
        try {
            const submitted = localStorage.getItem(SUBMITTED_IDS_KEY);
            return submitted ? JSON.parse(submitted) : {};
        } catch (e) {
            console.error("Error reading submitted IDs:", e);
            return {};
        }
    }
    function getPendingSubmissions() {
        try {
            const pending = localStorage.getItem(PENDING_SUBMISSIONS_KEY);
            return pending ? JSON.parse(pending) : [];
        } catch (e) {
            console.error("Error reading pending submissions:", e);
            return [];
        }
    }
    function isSubmissionSent(submissionId, domain) {
        try {
            const submitted = getSubmittedIds();
            const key = `${submissionId}_${domain}`;
            return !!submitted[key];
        } catch (e) {
            console.error("Error checking submission status:", e);
            return false;
        }
    }
    function cleanupOldSubmissions() {
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
        if (!document.hidden) {
            sendStoredSubmissions();
        }
    });
});
