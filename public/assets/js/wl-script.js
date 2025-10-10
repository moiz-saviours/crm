document.addEventListener("DOMContentLoaded", function () {
    let currentScript = getCurrentScript();
    let token = getScriptToken(currentScript);
    let apiBaseUrl = getApiBaseUrl(currentScript);

    // Storage key for pending submissions
    const STORAGE_KEY = "pending_lead_submissions";
    const MAX_RETRIES = 3;
    const RETRY_DELAY = 5000;

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

    function getAllScriptDomains() {
        const scripts = document.querySelectorAll('script[src*="wl-script.js"]');
        const domains = new Set();

        scripts.forEach(script => {
            try {
                const url = new URL(script.src);
                const baseUrl = getApiBaseUrl(script);
                if (baseUrl) {
                    domains.add(baseUrl);
                }
            } catch (e) {
                console.error("Error parsing script URL:", e);
            }
        });

        return Array.from(domains);
    }

    function generateSubmissionId() {
        return "sub_" + Math.random().toString(36).substr(2, 9) + Date.now();
    }

    function saveSubmissionToStorage(submission) {
        try {
            const pending = getPendingSubmissions();
            submission.id = submission.id || generateSubmissionId();
            submission.createdAt = submission.createdAt || new Date().toISOString();
            submission.retryCount = submission.retryCount || 0;

            pending.push(submission);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(pending));
            console.log("Submission saved to storage:", submission.id);
            return submission.id;
        } catch (e) {
            console.error("Error saving submission to storage:", e);
            return null;
        }
    }

    function getPendingSubmissions() {
        try {
            const pending = localStorage.getItem(STORAGE_KEY);
            return pending ? JSON.parse(pending) : [];
        } catch (e) {
            console.error("Error reading pending submissions:", e);
            return [];
        }
    }

    function removeSubmissionFromStorage(submissionId) {
        try {
            const pending = getPendingSubmissions();
            const filtered = pending.filter(sub => sub.id !== submissionId);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(filtered));
            console.log("Submission removed from storage:", submissionId);
        } catch (e) {
            console.error("Error removing submission from storage:", e);
        }
    }

    async function submitToDomain(domain, payload, submissionId = null) {
        return new Promise((resolve) => {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10s timeout

            const blob = new Blob([JSON.stringify(payload)], { type: "application/json" });

            fetch(`${domain}/brand-leads`, {
                method: 'POST',
                body: blob,
                headers: {
                    'Content-Type': 'application/json',
                },
                signal: controller.signal,
                keepalive: true // Similar to beacon behavior
            })
                .then(response => {
                    clearTimeout(timeoutId);
                    if (response.ok) {
                        console.log(`Successfully submitted to ${domain}`);
                        if (submissionId) {
                            removeSubmissionFromStorage(submissionId);
                        }
                        resolve({ success: true, domain, method: 'fetch' });
                    } else {
                        console.error(`Submission failed to ${domain}: ${response.status}`);
                        resolve({ success: false, domain, method: 'fetch', error: `HTTP ${response.status}` });
                    }
                })
                .catch(error => {
                    clearTimeout(timeoutId);
                    console.error(`Fetch failed for ${domain}:`, error);

                    const beaconSuccess = navigator.sendBeacon(`${domain}/brand-leads`, blob);
                    if (beaconSuccess) {
                        console.log(`Beacon fallback successful for ${domain}`);
                        if (submissionId) {
                            removeSubmissionFromStorage(submissionId);
                        }
                        resolve({ success: true, domain, method: 'beacon' });
                    } else {
                        console.error(`Beacon also failed for ${domain}`);
                        resolve({ success: false, domain, method: 'beacon', error: error.message });
                    }
                });
        });
    }

    async function submitToAllDomains(payload, isRetry = false) {
        const domains = getAllScriptDomains();
        const submissionId = isRetry ? payload.id : saveSubmissionToStorage(payload);

        if (!isRetry) {
            payload.id = submissionId;
        }

        console.log(`Submitting to ${domains.length} domains:`, domains);

        const results = await Promise.allSettled(
            domains.map(domain => submitToDomain(domain, payload, submissionId))
        );

        const allFailed = results.every(result =>
            result.status === 'fulfilled' && !result.value.success
        );

        if (allFailed && submissionId) {
            const pending = getPendingSubmissions();
            const submission = pending.find(sub => sub.id === submissionId);
            if (submission) {
                submission.retryCount = (submission.retryCount || 0) + 1;
                if (submission.retryCount <= MAX_RETRIES) {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(pending));
                    console.log(`Scheduled retry ${submission.retryCount}/${MAX_RETRIES} for submission ${submissionId}`);

                    setTimeout(() => {
                        processPendingSubmissions();
                    }, RETRY_DELAY);
                } else {
                    console.log(`Max retries exceeded for submission ${submissionId}`);
                    removeSubmissionFromStorage(submissionId);
                }
            }
        }

        return results;
    }

    async function processPendingSubmissions() {
        const pending = getPendingSubmissions();
        if (pending.length === 0) return;

        console.log(`Processing ${pending.length} pending submissions`);

        for (const submission of pending) {
            if (submission.retryCount < MAX_RETRIES) {
                await submitToAllDomains(submission, true);
                await new Promise(resolve => setTimeout(resolve, 1000));
            }
        }
    }

    function handleFormSubmit(form) {
        const visitor_id = getVisitorId();

        const formData = {};
        const fields = form.querySelectorAll("input, textarea, select");

        fields.forEach((field, index) => {
            if (field.name && field.value) {
                formData[field.name] = field.value;
            } else if (field.id && field.value) {
                formData[field.id] = field.value;
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
            submission_time: new Date().toISOString()
        };

        const payload = {
            visitor_id,
            script_token: token,
            form_data: formData,
            device_info: deviceInfo,
            submittedAt: new Date().toISOString()
        };

        submitToAllDomains(payload);
    }

    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            currentScript = getCurrentScript();
            token = getScriptToken(currentScript);
            apiBaseUrl = getApiBaseUrl(currentScript);

            handleFormSubmit(form);

            setTimeout(() => {
                form.removeEventListener('submit', arguments.callee);
                form.submit();
            }, 100);
        });
    });

    processPendingSubmissions();

    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            processPendingSubmissions();
        }
    });

    window.addEventListener('beforeunload', function() {
        const pending = getPendingSubmissions();
        if (pending.length > 0) {
            pending.forEach(submission => {
                const domains = getAllScriptDomains();
                const blob = new Blob([JSON.stringify(submission)], { type: "application/json" });

                domains.forEach(domain => {
                    navigator.sendBeacon(`${domain}/brand-leads`, blob);
                });
            });
        }
    });
});
