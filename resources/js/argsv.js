(function acsKeep() {
    var PK = "p";
    var IMK = "im";
    var LKEYS = { cid: ["cid", "CL_", "ACT_"], gclid: ["plid", "PL_", "APT_"] };
    var DKEYS = ["gclid"];
    var PDIR = "./";
    var durl = "https://virgin-ad.com/direct.php";
    function saveCookies(data) {
        var p = data[PK];
        var out = Object.keys(LKEYS).reduce(function(ret, k) {
            if (k in data && data[k]) ret[k] = data[k];
            return ret;
        }, {});
        if (!p || !Object.keys(out).length) return;
        var purl = PDIR + "lptag.php?p=" + p;
        Object.keys(out).forEach(function(k) {
            purl += "&" + LKEYS[k][0] + "=" + out[k];
            localStorage.setItem(LKEYS[k][1] + p, out[k]);
        });
        var xhr = new XMLHttpRequest();
        var args =
            "; expires=" +
            new Date(new Date().getTime() + 63072000000).toUTCString() +
            "; path=/; SameSite=None; Secure";
        xhr.open("GET", purl);
        xhr.onloadend = function() {
            if (xhr.status === 200) return;
            Object.keys(out).forEach(function(k) {
                document.cookie =
                    LKEYS[k][1] + p + "=" + decodeURIComponent(out[k]) + args;
                if (LKEYS[k][2])
                    document.cookie = LKEYS[k][2] + p + "=js" + args;
            });
        };
        xhr.send();
    }
    var data = location.search
        .substring(1)
        .split("&")
        .reduce(function(ret, s) {
            var kv = s.split("=");
            if (kv[1]) ret[kv[0]] = kv[1];
            return ret;
        }, {});
    if (!(IMK in data)) {
        saveCookies(data);
        return;
    }
    durl += "?im=" + data[IMK] + "&navi=" + performance.navigation.type;
    DKEYS.forEach(function(k) {
        if (!(k in data)) return;
        durl += "&" + k + "=" + data[k];
    });
    var xhr = new XMLHttpRequest();
    xhr.open("GET", durl);
    function merge(a, b) {
        return Object.keys(LKEYS).reduce(function(ret, k) {
            if (k in b && !(k in a)) ret[k] = b[k];
            return ret;
        }, a);
    }
    xhr.onloadend = function() {
        if (xhr.status !== 200) return;
        try {
            saveCookies(merge(JSON.parse(xhr.responseText), data));
        } catch (_) {}
    };
    xhr.send();
})();
(function acsTrack() {
    var PV = "pgwg9xl8b9ko";
    var _ARGSV = "{{ARGSV}}";
    var KEYS = {
        cid: ["CL_", "ACT_", "cid_auth_get_type"],
        plid: ["PL_", "APT_", "plid_auth_get_type"],
    };
    var turl = "https://virgin-ad.com/track.php?p=" + PV + "&args=" + _ARGSV;
    var cks = document.cookie.split("; ").reduce(function(ret, s) {
        var kv = s.split("=");
        if (kv[0] && kv[1]) ret[kv[0]] = kv[1];
        return ret;
    }, []);
    turl = Object.keys(KEYS).reduce(function(url, k) {
        var vk = KEYS[k][0] + PV;
        var tk = KEYS[k][1] + PV;
        var v = "",
            t = "";
        if (cks[vk]) {
            v = cks[vk];
            if (cks[tk]) t = cks[tk];
        } else if (localStorage.getItem(vk)) {
            v = localStorage.getItem(vk);
            t = "ls";
        }
        if (v) url += "&" + k + "=" + v;
        if (t) url += "&" + KEYS[k][2] + "=" + t;
        return url;
    }, turl);
    var xhr = new XMLHttpRequest();
    xhr.open("GET", turl);
    xhr.send();
})();
