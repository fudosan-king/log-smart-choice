var googleAuth = (function () {
    function installClient() {
        var apiUrl = 'https://apis.google.com/js/api.js';

        return new Promise((resolve) => {
            var script = document.createElement('script');
            script.src = apiUrl
            script.onreadystatechange = script.onload = function () {
                if (!script.readyState || /loaded|complete/.test(script.readyState)) {
                    setTimeout(function () {
                        resolve()
                    }, 500)
                }
            }
            document.getElementsByTagName('head')[0].appendChild(script)
        })
    }

    function initClient(config) {
        return new Promise((resolve) => {
            window.gapi.load('auth2', () => {
                window.gapi.auth2.init(config)
                    .then(() => {
                        resolve(window.gapi)
                    })
            })
        })
    }

    function Auth() {
        if (!(this instanceof Auth))
            return new Auth()
        this.GoogleAuth = null /* window.gapi.auth2.getAuthInstance() */
        this.isAuthorized = false
        this.isInit = false
        this.isLoaded = function () {
            console.warn('isLoaded() will be deprecated. You can use "this.$gAuth.isInit"')
            return !!this.GoogleAuth
        }

        this.load = (config) => {
            installClient()
                .then(() => {
                    return initClient(config)
                })
                .then((gapi) => {
                    this.GoogleAuth = gapi.auth2.getAuthInstance()
                    this.isInit = true
                    this.prompt = prompt
                    this.isAuthorized = this.GoogleAuth.isSignedIn.get()
                })
        }
    }

    return new Auth()
})()

function installGoogleAuthPlugin(Vue, options) {
    //set config
    let GoogleAuthConfig = null
    let GoogleAuthDefaultConfig = {
        scope: 'https://www.googleapis.com/auth/userinfo.profile',
        discoveryDocs: []
    }
    if (typeof options === 'object') {
        GoogleAuthConfig = Object.assign(GoogleAuthDefaultConfig, options);
        if (options.scope) GoogleAuthConfig.scope = options.scope;
        if (!options.clientId) {
            console.warn('clientId is required');
        }
    } else {
        console.warn('invalid option type. Object type accepted only');
    }

    googleAuth.load(GoogleAuthConfig);
}

export default installGoogleAuthPlugin;