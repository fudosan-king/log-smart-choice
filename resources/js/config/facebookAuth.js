export default ({}, fbOption) => {
    return new Promise(resolve => {
        var js,
            fjs = document.getElementsByTagName("script")[0];
        if (document.getElementById("facebook-jssdk")) {
            return;
        }
        js = document.createElement("script");
        js.id = fbOption.jsID;
        js.src = fbOption.jsSrc;
        fjs.parentNode.insertBefore(js, fjs);
        let appID = fbOption.appID;
        let version = fbOption.version;
        window.fbAsyncInit = function () {
            FB.init({
                appId: appID,
                xfbml: true,
                version: version
            });
            FB.AppEvents.logPageView();
        };
    })
}