import VueRouter from 'vue-router';

// Pages
import Home from '../../js/pages/Home.vue';
import Login from '../../js/pages/Login.vue';
import ListEstates from '../../js/pages/ListEstates.vue';
import DetailEstate from '../../js/pages/DetailEstate.vue';
import PageNotFound from '../pages/PageNotFound.vue';

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

    // const isLogged = !!store.getters.customerInfo
    // if (isLogged && to.meta.guest) {
    //     return router.push('/')
    // }
})

export default router