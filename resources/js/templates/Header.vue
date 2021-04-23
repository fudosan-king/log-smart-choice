<template>
    <header v-if="page === 'home'">
        <div class="navbar navbar-expand-lg bsnav bsnav-transparent">
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.logknot.co.jp/">会社概要</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo }} 様</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link" v-on:click="logout">
                            <img alt="" class="img-fluid" width="16" /> ログアウト
                        </a>
                    </li>

                    <li v-else class="nav-item">
                        <a class="nav-link" v-bind:href="'/login'"><span>ログイン</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <header v-else-if="page === 'detail'">
        <div class="navbar navbar-expand-lg bsnav bsnav-transparent">
            <a class="navbar-brand" v-bind:href="'/'"
                ><img v-bind:src="logoBlack" alt="" class="img-fluid" width="220"
            /></a>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.logknot.co.jp/">会社概要</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo }} 様</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link" v-on:click="logout">
                            <img alt="" class="img-fluid" width="16" /> ログアウト
                        </a>
                    </li>

                    <li v-else class="nav-item">
                        <a class="nav-link" v-bind:href="'/login'"><span>ログイン</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <header class="sub_header" v-else>
        <div class="navbar navbar-expand-lg bsnav">
            <a class="navbar-brand" v-bind:href="'/'"
                ><img v-bind:src="logoBlack" alt="" class="img-fluid" width="220"
            /></a>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.logknot.co.jp/">会社概要</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo }} 様</a>
                    </li>
                    <li v-if="customerInfo" class="nav-item nav-header">
                        <a class="nav-link" v-on:click="logout">
                            <img alt="" class="img-fluid" width="16" /> ログアウト
                        </a>
                    </li>

                    <li v-else class="nav-item">
                        <a class="nav-link" v-bind:href="'/login'"><span>ログイン</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>
<script>
export default {
    data() {
        const logoBlack = '/assets/images/SVG/logo_orderrenove_black.svg';
        let page = '';
        if (this.$route.name) {
            page = this.$route.name;
        }

        return {
            page: page,
            logoBlack: logoBlack
        };
    },
    methods: {
        logout() {
            this.$store
                .dispatch('logout')
                .then(response => {
                    this.$setCookie('accessToken', '', 1);
                    this.$setCookie('accessToken3d', '', 1);
                    this.$setCookie('userName', '', 1);
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go(0);
                })
                .catch(error => {});
        }
    },
    computed: {
        customerInfo() {
            return this.$getCookie('userName');
        }
    }
};
</script>
