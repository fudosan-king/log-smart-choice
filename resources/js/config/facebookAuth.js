export default () => {
    return new Promise(resolve => {
        var js,
            fjs = document.getElementsByTagName("script")[0];
        if (document.getElementById("facebook-jssdk")) {
            return;
        }
        js = document.createElement("script");
        js.id = "facebook-jssdk";
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);

        window.fbAsyncInit = function () {
            FB.init({
                appId: process.env.MIX_FACEBOOK_APP_ID,
                xfbml: true,
                version: 'v10.0'
            });
            FB.AppEvents.logPageView();
        };
    })
}