<template>
    <div>
        <header>
            <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-sticky-slide">
                <a class="navbar-brand" v-bind:href="'/'"
                    ><img v-bind:src="iconLogo" alt="" class="img-fluid" width="200"
                /></a>
                <button class="navbar-toggler toggler-spring">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-md-end">
                    <ul class="navbar-nav navbar-mobile mr-0">
                        <li class="nav-item">
                            <a class="nav-link active" v-bind:href="'/'">物件＋リノベーション</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">リノベーションプラン集</a>
                        </li>
                        <li v-if="customerInfo.name">
                            <div class="nav-link" v-on:click="logout">
                                ようこそ {{ customerInfo.name }} 様。
                                <img v-bind:src="iconUser" alt="" class="img-fluid" width="16" /> Logout
                            </div>
                        </li>
                        <li v-else>
                            <a class="nav-link" v-bind:href="'/login'"
                                ><img v-bind:src="iconUser" alt="" class="img-fluid" width="16" /> ログイン</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tel:000-0000-0000"
                                >000-0000-0000
                                <span>年中無休8:00〜18:30</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">オンライン問い合わせ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="spacing"></div>
    </div>
</template>
<script>
import { mapState } from 'vuex';

export default {
    data() {
        const iconLogo = '/design/images/SVG/logo.svg';
        const iconUser = '/design/images/SVG/i_user.svg';

        return {
            iconLogo: iconLogo,
            iconUser: iconUser
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
