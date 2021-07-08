export default {
    install(Vue, options) {

        Vue.auth = {
            username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
            password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`
        };
        Vue.prototype.$setCookie = (name, value, exdays) => {
            var date = new Date();
            date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + date.toUTCString();
            if (name == 'accessToken3d') {
                document.cookie = name + "=" + value + ";" + expires + ";path=/" + ";domain=.order-renove.jp";
            } else {
                document.cookie = name + "=" + value + ";" + expires + ";path=/";
            }
        };

        Vue.prototype.$getCookie = (name) => {
            var newName = name + "=";
            var sliptCookie = document.cookie.split(';');
            for (var i = 0; i < sliptCookie.length; i++) {
                var character = sliptCookie[i];
                while (character.charAt(0) == ' ') {
                    character = character.substring(1);
                }
                if (character.indexOf(name) == 0) {
                    return character.substring(newName.length, character.length);
                }
            }
            return "";
        };

        Vue.prototype.$lscFormatCurrency = (value, currency = '') => {
            if (typeof value === 'undefined') {
                return '';
            }
            if (value && value.toString().length > 3) {
                value = value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
            return currency + value;
        }
    }
};