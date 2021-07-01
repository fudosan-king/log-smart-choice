import VueRouter from 'vue-router';
import store from '../store/index';

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../../js/pages/Home.vue'),
    },
    {
        path: '/list',
        name: 'list',
        component: () => import('../../js/pages/ListEstates.vue'),
    },
    {
        path: '/detail/:estateId',
        name: 'detail',
        component: () => import('../../js/pages/DetailEstate.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../../js/pages/Login.vue'),
        meta: {
            guest: true,
        },
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../pages/About.vue'),
    },
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../pages/Contact.vue'),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../pages/Register.vue'),
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: () => import('../pages/ForgotPassword.vue'),
    },
    { path: "*", component: () => import('../pages/PageNotFound.vue') },
    {
        path: '/login-social',
        name: 'loginSocial',
        component: () => import('../pages/LoginSocial.vue'),
    },
    {
        path: '/reconfirmation-email',
        name: 'reconfirmEmail',
        component: () => import('../pages/ReconfirmEmail.vue'),
    },
    {
        path: '/customer/:verify/active-email',
        name: 'activeEmail',
        component: () => import('../pages/ActiveEmail.vue'),
    },
    {
        path: '/customer/information',
        name: 'information',
        component: () => import('../pages/AccountInformation.vue'),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/customer/change-password',
        name: 'ChangePassword',
        component: () => import('../pages/ChangePassword.vue'),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/customer/update',
        name: 'updateInformation',
        component: () => import('../pages/UpdateInformation.vue'),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/customer/announcement-condition',
        name: 'announcementCondition',
        component: () => import('../pages/AnnouncementCondition.vue'),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/welcome',
        name: 'wecome',
        component: () => import('../pages/Welcome.vue'),
    },
]

const router = new VueRouter({
    mode: 'history',
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }

    if (store.getters.isLoggedIn && to.meta.guest) {
        return router.push('/')
    }
})

export default router