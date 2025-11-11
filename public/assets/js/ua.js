const url = new URL(document.currentScript.src);
const token = url.searchParams.get("token");
!function (t, e, r) {
    if (!document.getElementById(t)) {
        var basePath = document.currentScript.src.substring(0, currentScriptSrc.lastIndexOf('/'));
        var n = document.createElement("script");
        for (var a in n.src = basePath + "/user-activity.js?token="+token, n.type = "text/javascript", n.id = t, r) r.hasOwnProperty(a) && n.setAttribute(a, r[a]);
        var i = document.getElementsByTagName("script")[0];
        i.parentNode.insertBefore(n, i)
    }
}("CollectedForms", 0, {
    "crossorigin": "anonymous",
    "data-token": token,
});
!function (t, e, r) {
    if (!document.getElementById(t)) {
        var basePath = document.currentScript.src.substring(0, currentScriptSrc.lastIndexOf('/'));
        var n = document.createElement("script");
        for (var a in n.src = basePath + "/wl-script.js?token="+token, n.type = "text/javascript", n.id = t, r) r.hasOwnProperty(a) && n.setAttribute(a, r[a]);
        var i = document.getElementsByTagName("script")[0];
        i.parentNode.insertBefore(n, i)
    }
}("CollectedForms", 0, {
    "crossorigin": "anonymous",
    "data-token": token,
});
