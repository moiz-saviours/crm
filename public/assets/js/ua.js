(() => {
    var url = new URL(document.currentScript.src);
    const token = url.searchParams.get("token");

    (function (t, e, r) {
        if (!document.getElementById(t)) {
            var basePath = document.currentScript.src.substring(0, document.currentScript.src.lastIndexOf('/'));
            var n = document.createElement("script");
            for (var a in r) if (r.hasOwnProperty(a)) n.setAttribute(a, r[a]);
            n.src = basePath + "/user-activity.js?token=" + token;
            n.type = "text/javascript";
            n.id = t;
            var i = document.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(n, i);
        }
    })("CollectedForms1", 0, {
        "crossorigin": "anonymous",
        "data-token": token,
    });

    (function (t, e, r) {
        if (!document.getElementById(t)) {
            var basePath = document.currentScript.src.substring(0, document.currentScript.src.lastIndexOf('/'));
            var n = document.createElement("script");
            for (var a in r) if (r.hasOwnProperty(a)) n.setAttribute(a, r[a]);
            n.src = basePath + "/wl-script.js?token=" + token;
            n.type = "text/javascript";
            n.id = t;
            var i = document.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(n, i);
        }
    })("CollectedForms2", 0, {
        "crossorigin": "anonymous",
        "data-token": token,
    });
})();
