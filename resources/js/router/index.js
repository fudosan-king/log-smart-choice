import VueRouter from 'vue-router';

// Pages
import Home from '../../js/pages/Home.vue';
import Login from '../../js/pages/Login.vue';
import ListEstates from '../../js/pages/ListEstates.vue';
import DetailEstate from '../../js/pages/DetailEstate.vue';

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
]

const router = new VueRouter({
    mode: 'history',
    routes,
    base: process.env.BASE_URL,
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
})

export default router