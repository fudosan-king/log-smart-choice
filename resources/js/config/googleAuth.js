export default ({ }, gOption) => {
    return new Promise((resolve, reject) => {
        let apiUrl = gOption.jsSrc;
        let js = document.createElement('script');
        js.src = apiUrl
        js.onreadystatechange = js.onload = function () {
            if (!js.readyState || /loaded|complete/.test(js.readyState)) {
                setTimeout(function () {
                    resolve()
                }, 500)
            }
        }
        document.getElementsByTagName('head')[0].appendChild(js);
    }).then(() => {
        window.gapi.load('client:auth2', async () => {
            try {
                await window.gapi.client.init({
                    client_id: gOption.clientId,
                    discoveryDocs: [],
                    scope: gOption.scope,
                });
            } catch (error) { }
        });
    });
}