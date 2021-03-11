import VueRouter from 'vue-router';

// Pages
import Home from '../../js/pages/Home.vue';
import Login from '../../js/pages/Login.vue';
import ListEstates from '../../js/pages/ListEstates.vue';
import DetailEstate from '../../js/pages/DetailEstate.vue';
import PageNotFound from '../pages/PageNotFound.vue';
import About from '../pages/About.vue';
import Contact from '../pages/Contact.vue';
import Register from '../pages/Register.vue';
import ForgotPassword from '../pages/ForgotPassword.vue';

// store
import store from '../store/index';

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/list',
        name: 'list',
        component: ListEstates,
    },
    {
        path: '/detail/:estateId',
        name: 'detail',
        component: DetailEstate,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guest: true,
        },
    },
    {
        path: '/about',
        name: 'about',
        component: About,
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: ForgotPassword,
    },
    { path: "*", component: PageNotFound }
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