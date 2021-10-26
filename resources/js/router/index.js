import VueRouter from 'vue-router';
import store from '../store/index';
import axios from 'axios';
import Vue from 'vue';
import globalHelper from '../globalHelper';

Vue.use(globalHelper);

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../../js/pages/Home.vue'),
        meta: {
            title: 'リノベーションをするならオーダーリノベ ｜Order Renove'
        }
    },
    {
        path: '/list',
        name: 'list',
        component: () => import('../../js/pages/ListEstates.vue'),
        meta: {
            title: '全物件一覧｜Order Renove'
        }
    },
    {
        path: '/list/:searchCode',
        name: 'listByCode',
        component: () => import('../../js/pages/ListEstates.vue'),
        meta: {
            title: 'の物件一覧｜Order Renove'
        }
    },
    // {
    //     path: '/list/:districtCode',
    //     name: 'listByDistrict',
    //     component: () => import('../../js/pages/ListEstatesByDistrict.vue'),
    // },
    // {
    //     path: '/list/:companyCode/:stationCode',
    //     name: 'listByStation',
    //     component: () => import('../../js/pages/ListEstates.vue'),
    // },
    {
        path: '/detail/:estateId',
        name: 'detail',
        component: () => import('../../js/pages/DetailEstate.vue'),
        meta: {
            title: '｜Order Renove'
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../../js/pages/Login.vue'),
        meta: {
            guest: true,
            title: 'ログイン｜Order Renove'
        }
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../pages/About.vue')
    },
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../pages/Contact.vue'),
        meta: {
            title: 'への 内見・お問い合わせ入力｜Order Renove'
        }
    },
    {
        path: '/contact/confirm',
        name: 'contactConfirm',
        component: () => import('../pages/ContactConfirm.vue'),
        meta: {
            title: 'への 内見・お問い合わせ確認｜Order Renove'
        }
    },
    {
        path: '/contact/thanks',
        name: 'contactSuccess',
        component: () => import('../pages/ContactSuccess.vue'),
        meta: {
            title: 'への 内見・お問い合わせ完了｜Order Renove'
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../pages/Register.vue'),
        meta: {
            title: '新規会員登録｜Order Renove'
        }
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: () => import('../pages/ForgotPassword.vue'),
        meta: {
            title: '忘れたパスワード｜Order Renove'
        }
    },
    { path: '*', component: () => import('../pages/PageNotFound.vue') },
    {
        path: '/login-social',
        name: 'loginSocial',
        component: () => import('../pages/LoginSocial.vue')
    },
    {
        path: '/reconfirmation-email',
        name: 'reconfirmEmail',
        component: () => import('../pages/ReconfirmEmail.vue'),
        meta: {
            title: '確認メールの再送信｜Order Renove'
        }
    },
    {
        path: '/customer/information',
        name: 'information',
        component: () => import('../pages/AccountInformation.vue'),
        meta: {
            requiresAuth: true,
            title: '登録情報｜Order Renove'
        }
    },
    {
        path: '/customer/change-password',
        name: 'ChangePassword',
        component: () => import('../pages/ChangePassword.vue'),
        meta: {
            requiresAuth: true,
            title: 'パスワード設定｜Order Renove'
        }
    },
    {
        path: '/customer/update',
        name: 'updateInformation',
        component: () => import('../pages/UpdateInformation.vue'),
        meta: {
            requiresAuth: true,
            title: '登録情報の更新｜Order Renove'
        }
    },
    {
        path: '/wishlist',
        name: 'wishlist',
        component: () => import('../pages/Wishlist.vue'),
        meta: {
            requiresAuth: true,
            title: 'お気に入り物件一覧｜Order Renove'
        }
    },
    {
        path: '/notice',
        name: 'notice',
        component: () => import('../pages/Notice.vue'),
        meta: {
            requiresAuth: true,
            title: '希望条件にあった物件一覧｜Order Renove'
        }
    },
    {
        path: '/customer/announcement-condition',
        name: 'announcementCondition',
        component: () => import('../pages/AnnouncementCondition.vue'),
        meta: {
            requiresAuth: true,
            title: 'メルマガ配信希望条件｜Order Renove'
        }
    },
    {
        path: '/customer/:verify/active-email',
        name: 'welcome',
        component: () => import('../pages/Welcome.vue'),
        meta: {
            title: '会員登録完了｜Order Renove'
        }
    },
    {
        path: '/reset-password/:verify',
        name: 'resetPassword',
        component: () => import('../pages/ResetPassword.vue'),
        meta: {
            title: 'パスワードを再設定する｜Order Renove'
        }
    },
    {
        path: '/fast-register',
        name: 'fastRegister',
        component: () => import('../pages/FastRegister.vue'),
        meta: {
            title: 'メルマガ配信希望条件｜Order Renove'
        }
    },
    {
        path: '/register-thank-you',
        name: 'RegisterThankYou',
        component: () => import('../pages/RegisterThankYou.vue'),
        meta: {
            title: '会員登録申請完了｜Order Renove'
        }
    },
    {
        path: '/contact-thanks-guest',
        name: 'ContactThanksGuest',
        component: () => import('../pages/ContactThanksGuest.vue'),
        meta: {
            title: '物件問い合わせ完了｜Order Renove'
        }
    },
    {
        path: '/contact-thanks-customer',
        name: 'ContactThanksCustomer',
        component: () => import('../pages/ContactThanksCustomer.vue'),
        meta: {
            title: '物件問い合わせ完了｜Order Renove'
        }
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    let title = '';
    if (to.name === 'listByCode') {
        if (window.localStorage.getItem('searchCode')) {
            title = window.localStorage.getItem('searchCode') + 'の物件一覧|Order Renove';
        }
    } else if (['contact', 'contactConfirm', 'contactSuccess'].includes(to.name)) {
        title = window.localStorage.getItem('estateName') + to.meta.title;
    } else {
        title = to.meta.title;
    }

    // private meta
    let metaHTML = '';
    if (!store.getters.isLoggedIn) {
        metaHTML += metaTagsWithGues(to, title);
    }

    let imageSrc = `${window.location.origin}/assets/images/svg/logo_orderrenove_white.svg`;

    let estateID = to.params.estateId;
    let searchCode = to.params.searchCode;
    if (to.name === 'detail') {
        axios.get(`${process.env.MIX_APP_URL}/api/get-meta-tags`, { params: { estateID: estateID } }).then(response => {
            let totalPrice = response.data.dataInfo.price;
            let address =
                response.data.dataInfo.address.pref +
                response.data.dataInfo.address.city +
                response.data.dataInfo.address.ooaza +
                response.data.dataInfo.address.tyoume;
            let addressDescription =
                response.data.dataInfo.address.pref +
                response.data.dataInfo.address.city +
                response.data.dataInfo.address.ooaza +
                response.data.dataInfo.address.tyoume +
                response.data.dataInfo.address.gaikutiban;
            let title = `${response.data.dataInfo.estate_name}｜${address}｜${totalPrice}/${response.data.dataInfo.tatemono_menseki}/${response.data.dataInfo.room_floor}/${response.data.dataInfo.structure}｜Order Renove`;
            let contentAddressDiscription = `${response.data.dataInfo.estate_name}｜${addressDescription}のリノベーション物件を探すならOrderRenove（オーダーリノベ）。大手ポータルサイトに載っていない掘り出しものの物件も掲載しています。会員登録すれば${response.data.dataInfo.estate_name}｜${addressDescription}のリノベーション済、リノベーション向きの物件もご希望に合った物件情報をお届けします。`;
            document.title = title;
            if (typeof response.data.dataInfo.estate_information !== 'undefined') {
                imageSrc = response.data.dataInfo.estate_information.estate_main_photo;
            }
            metaHTML += `<meta property="og:image" content="${imageSrc}"></meta>`;
            metaHTML += `<meta property="og:title" content="${title}">`;
            metaHTML += `<meta name="property" content="${contentAddressDiscription}">`;
            document.head.innerHTML += metaHTML;
        });
    } else {
        if (to.name == 'listByCode') {
            axios.get(`${process.env.MIX_APP_URL}/api/get-meta-code-search`, { params: { search_code: searchCode } }).then(response => {
                let name = response.data.data.name;
                metaHTML += `<meta name="property" content="${name}のリノベーション物件を探すならOrderRenove（オーダーリノベ）。大手ポータルサイトに載っていない掘り出しものの物件も掲載しています。会員登録すれば${name}のリノベーション済、リノベーション向きの物件もご希望に合った物件情報をお届けします。">`;
                document.head.innerHTML += metaHTML;
            });
        }
        document.title = title;
        metaHTML += `<meta property="og:image" content="${imageSrc}">`;
        metaHTML += `<meta property="og:title" content="${to.meta.title}">`;
        document.head.innerHTML += metaHTML;
    }
    // let marketingString = '';
    // if (to.name == 'contactSuccess') {
    //     let orderRenoveCustomerId = window.localStorage.getItem('orderrenoveCustomerId');
    //     marketingString += `<script>var msmaf_m_v="${orderRenoveCustomerId}"; var a8_affiliate_id="${orderRenoveCustomerId}"; var tamaru_id="${orderRenoveCustomerId}"; var imaf_uid="${orderRenoveCustomerId}";</script>`;
    //     marketingString += `<script>window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'a8_affiliate_id': "${orderRenoveCustomerId}",}); </script>`;
    //     marketingString += `<script>window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'msmaf_m_v': "${orderRenoveCustomerId}",}); </script>`;
    //     marketingString += `<script>window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'tamaru_id': "${orderRenoveCustomerId}",}); </script>`;
    //     marketingString += `<script>window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'imaf_uid': "${orderRenoveCustomerId}",}); </script>`;
    //     document.head.innerHTML += marketingString;
    // }

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('accessToken')) {
            next();
        } else {
            return router.push('/login').catch(() => {});
        }
    } else {
        next();
    }
});

const metaTagsWithGues = (to, title) => {
    let fullPath = window.location.origin + to.fullPath;
    let metaHTML = `<link rel="canonical" href="${fullPath}">`;
    let type = 'website';
    if (to.name === 'list') {
        type = 'article';
    }
    metaHTML += `
        <meta property="og:type" content="${type}">
        <meta property="og:url" content="${fullPath}">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="og:site_name" content="Order Renove（オーダーリノベ）">
    `;
    if (['home', 'list', 'listByCode', 'detail', 'login'].includes(to.name)) {
        metaHTML += `
            <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
        `;
    }
    if (to.name == 'home') {
        metaHTML += `
            <meta name="property" content="リノベーション物件を探すならOrderRenove（オーダーリノベ）。大手ポータルサイトに載っていない掘り出しものの物件も掲載しています。会員登録すればリノベーション済、リノベーション向きの物件もご希望に合った物件情報をお届けします。">
        `;
    } else if (to.name == 'login') {
        metaHTML += `
            <meta name="property" content="リノベーション物件を探すならOrderRenove（オーダーリノベ）。無料会員登録でリノベーション済、リノベーション向きの物件もご希望に合った大手ポータルサイトに載っていない掘り出しものの物件もお届けします。">
        `;
    } else if (to.name == 'register') {
        metaHTML += `
            <meta name="property" content="リノベーション物件を探すならOrderRenove（オーダーリノベ）。無料会員登録でリノベーション済、リノベーション向きの物件もご希望に合った大手ポータルサイトに載っていない掘り出しものの物件もお届けします。">
        `;
    } else if (to.name == 'list') {
        metaHTML += `
            <meta name="property" content="首都圏のリノベーション物件を探すならOrderRenove（オーダーリノベ）。大手ポータルサイトに載っていない掘り出しものの物件も掲載しています。会員登録すれば首都圏のリノベーション済、リノベーション向きの物件もご希望に合った物件情報をお届けします。">
        `;
    }

    return metaHTML;
};

export default router;
