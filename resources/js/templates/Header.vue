<template>
    <div class="navigation sp-fixed " :class="{'nav-black': isScroll || !homePage, 'nav-fixed nav-white': homePage }">
        <header :class="{ 'nav-animation-scroll': isScroll }">
            <div class="nav_menu">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="/">

                        <img v-if="homePage"
                            src="/assets/images/svg/logo_orderrenove_white.svg"
                            alt=""
                            class="img-fluid logo-white"
                            width="160"
                            height="160"
                        />
                        <img v-else
                            src="/assets/images/svg/logo_orderrenove_black.svg"
                            alt=""
                            class="img-fluid logo-black"
                            width="160"
                            height="160"
                        />
                        <img
                            v-if="isScroll && homePage"
                            src="/assets/images/svg/logo_orderrenove_black.svg"
                            alt=""
                            class="img-fluid logo-black"
                            width="160"
                            height="160"
                        />
                        <!-- <img
                            v-if="homePage"
                            src="/assets/images/svg/logo_orderrenove_black.svg"
                            alt=""
                            class="img-fluid"
                            v-bind:class="[homeBlackClass]"
                            width="160"
                            height="160"
                        />
                        <img
                            v-else
                            src="/assets/images/svg/logo_orderrenove_black.svg"
                            alt=""
                            class="img-fluid"
                            v-bind:class="[homeBlackClass]"
                            width="160"
                            height="160"
                        /> -->
                    </a>
                    <!-- <div class="ml-auto box_user">
                        <div class="dropdown dropdown_user">
                            <a
                                class="dropdown_user"
                                v-bind:id="[!homePage ? 'dropdown_user' : '']"
                                href="javascript:void(0)"
                                v-on:click="dropUser"
                            >
                                <img
                                    src="/assets/images/svg/i_user.svg"
                                    alt=""
                                    class="img-fluid"
                                    v-bind:class="[homeWhiteClass]"
                                    width="15"
                                    height="15"
                                />
                                <img
                                    src="/assets/images/svg/i_user_black.svg"
                                    alt=""
                                    class="img-fluid"
                                    v-bind:class="[homeBlackClass]"
                                    width="15"
                                    height="15"
                                />
                                <span v-if="userName">ログイン中</span>
                                <span v-else>ログイン</span>
                            </a>
                            <div class="dropdown_user_content" style="display: none;">
                                <ul>
                                    <li>
                                        <a href="/customer/information">会員登録情報</a>
                                    </li>
                                    <li><a href="/customer/announcement-condition">メルマガ配信希望条件</a></li>
                                    <li><a href="/wishlist">お気に入り</a></li>
                                    <li><a href="javascript:void(0)" v-on:click="logout">ログアウト</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="dropdown dropdown_search">
                            <a id="dropdown_search" href="/search">
                                <img
                                    src="/assets/images/svg/i_search.svg"
                                    alt=""
                                    class="img-fluid"
                                    v-bind:class="[homeWhiteClass]"
                                    width="16"
                                    height="16"
                                />
                                <img
                                    src="/assets/images/svg/i_search_black.svg"
                                    alt=""
                                    class="img-fluid"
                                    v-bind:class="[homeBlackClass]"
                                    width="16"
                                    height="16"
                                />
                            </a>
                            <div class="dropdown_search_content" style="display: none;">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-block text-left collapsed"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#collapseOne"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne"
                                                    ref="showArea"
                                                    v-on:click="setCondition('district')"
                                                >
                                                    <img
                                                        src="/images/svg/i_map_black.svg"
                                                        alt=""
                                                        class="img-fluid"
                                                        width="18"
                                                        height="18"
                                                    />
                                                    エリアから探す
                                                </button>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-block text-left collapsed"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#collapseTwo"
                                                    aria-expanded="false"
                                                    aria-controls="collapseTwo"
                                                    ref="showStation"
                                                    v-on:click="setCondition('station')"
                                                >
                                                    <img
                                                        src="/assets/images/svg/i_stations_black.svg"
                                                        alt=""
                                                        class="img-fluid"
                                                        width="13"
                                                        height="13"
                                                    />
                                                    <span>沿線から探す</span>
                                                </button>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="" id="headingOne">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-block text-center"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#collapseOne"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne"
                                                    ref="showArea"
                                                    v-on:click="closeSearch()"
                                                >
                                                    閉じる
                                                </button>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <button class="navbar-toggler js-menu" type="button" v-on:click="menuAction">
                        <span class="nav-toggler-line"></span>
                        <span class="nav-toggler-line"></span>
                        <span class="nav-toggler-line"></span>
                    </button>
                    <div class="nav_menu-list">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="sub-link nav-link" href="#"> マイページ</a>
                                <ul v-if="userName">
                                    <!-- <li><a href="#">マイページ</a></li> -->
                                    <li><a href="/customer/information">会員登録情報</a></li>
                                    <li><a href="/wishlist">お気に入り</a></li>
                                    <li><a href="/customer/announcement-condition">メルマガ希望条件</a></li>
                                    <li><a href="javascript:void(0)" v-on:click="logout">ログアウト</a></li>
                                </ul>
                                <ul v-else>
                                    <li>
                                        <a href="javascript:void(0)" v-on:click="redirectLogin">ログイン／会員登録</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">OrderRenoveについて<i class="c-icon i-arrow-gray"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/list">物件一覧<i class="c-icon i-arrow-gray"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">リノベプラン一覧<i class="c-icon i-arrow-gray"></i></a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">コンシェルジュ相談<i class="c-icon i-arrow-gray"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    >マネー診断シミュレーター<i class="c-icon i-arrow-gray"></i
                                ></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">売却サポート<i class="c-icon i-arrow-gray"></i></a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.logrenove.jp/"
                                    >LogRenove ライフスタイルメディア<i class="c-icon i-arrow-gray"></i
                                ></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/fast-register">ご利用ガイド<i class="c-icon i-arrow-gray"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    </div>
</template>
<script>
export default {
    data() {
        let page = '';
        if (this.$route.name) {
            page = this.$route.name;
        }
        let userName = this.$getLocalStorage('userName');
        return {
            page: page,
            userName: userName,
            districtList: {},
            stationList: {},
            transportCompanyList: {},
            announcementCount: 0,
            homePage: true,
            homeWhiteClass: '',
            homeBlackClass: '',
            isScroll: false
        };
    },
    created() {
        if (this.$route.name == 'home') {
            this.homePage = true;
            this.homeWhiteClass = 'd-none d-lg-inline-block';
            this.homeBlackClass = 'd-inline-block d-lg-none';
        } else {
            this.homePage = false;
            this.homeWhiteClass = 'i_white';
            this.homeBlackClass = 'i_black';
        }
    },
    mounted() {
        window.addEventListener('scroll', this.scrollListener);
        this.getDistrict();
    },
    methods: {
        logout() {
            this.$store
                .dispatch('logout')
                .then(response => {
                    this.$setCookie('accessToken3d', '', 1);
                    this.$removeAuthLocalStorage();
                    this.$removeLocalStorage('announcement_count');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$removeLocalStorage('district');
                    this.$removeLocalStorage('station');
                    this.$router.go(0);
                })
                .catch(error => {
                    this.$setCookie('accessToken3d', '', 1);
                    this.$removeAuthLocalStorage();
                    this.$removeLocalStorage('announcement_count');
                    this.$router.push({ name: 'login' }).catch(() => {});
                });
        },

        redirectLogin(event) {
            this.$store
                .dispatch('customerInfo')
                .then(resp => {
                    event.preventDefault();
                    $('.dropdown_user_content').slideToggle('fast');
                    $('.dropdown_search_content').hide();
                    this.announcementCount = this.$getCookie('announcement_count');
                })
                .catch(err => {
                    this.$setCookie('accessToken3d', '', 1);
                    this.$removeAuthLocalStorage();
                    this.$removeLocalStorage('announcement_count');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.push({ name: 'login' }).catch(() => {});
                });
        },

        scrollListener() {
            if (window.pageYOffset > 0) {
                this.isScroll = true;
                $('.navigation').removeClass('nav-fixed nav-white');
            } else {
                this.isScroll = false;
            }
        },

        getDistrict() {
            this.$store.dispatch('getDistrict').then(response => {
                this.districtList = response.data;
            });
        },

        setCondition(condition) {
            if (condition == 'district') {
                this.$setLocalStorage('tabActive', 'area');
            } else {
                this.$setLocalStorage('tabActive', 'station');
            }
            this.$router
                .push({ name: 'EstateSearch' })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        menuAction() {
            if ($('.js-menu').hasClass('open') == false) {
                $('body').addClass('menu-opened menu-opening');
                $('.js-menu').addClass('open');
                $('.nav_menu-list').addClass('show');
            } else {
                $('body').removeClass('menu-opened menu-opening');
                $('.js-menu').removeClass('open');
                $('.nav_menu-list').removeClass('show');
            }
        }
    }
};
</script>
