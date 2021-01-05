<template>
    <header v-if="page === 'home'">
        <div class="navbar navbar-expand-lg bsnav bsnav-transparent">
            <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">会社概要</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo.name }} 様。</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
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
                ><img v-bind:src="logoBlack" alt="" class="img-fluid" width="217"
            /></a>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">会社概要</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo.name }} 様。</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
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
                ><img v-bind:src="logoBlack" alt="" class="img-fluid" width="217"
            /></a>
            <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">会社概要</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
                        <a class="nav-link">ようこそ {{ customerInfo.name }} 様。</a>
                    </li>
                    <li v-if="customerInfo.name" class="nav-item nav-header">
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
import { mapState } from 'vuex';

export default {
    data() {
        const logoBlack = '/assets/images/SVG/LogRenove_logo_black.svg';
        let page = this.$route.name;
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
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token');
                    this.$router.go(0);
                })
                .catch(error => {});
        }
    },
    computed: {
        customerInfo() {
            return this.$store.getters.customerInfo;
        }
    }
};
</script>
