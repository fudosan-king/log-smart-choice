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
        var appID = fbOption.appID;
        window.fbAsyncInit = function () {
            FB.init({
                appId: appID,
                xfbml: true,
                version: 'v10.0'
            });
            FB.AppEvents.logPageView();
        };
    })
}