<template>
    <header class="fixed-top" :class="{subheader: !homePage, compressed: isScroll}">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <a class="navbar-brand" href="/">
                <img 
                    src="/assets/images/svg/logo_orderrenove_white.svg"
                    alt=""
                    class="img-fluid"
                    v-bind:class="[homeWhiteClass]"
                    width="224"
                />
                <img v-if="homePage"
                    src="/assets/images/svg/logo_orderrenove_black.svg"
                    alt=""
                    class="img-fluid"
                    v-bind:class="[homeBlackClass]"
                    width="134"
                />
                <img v-else
                    src="/assets/images/svg/logo_orderrenove_black.svg"
                    alt=""
                    class="img-fluid"
                    v-bind:class="[homeBlackClass]"
                    width="224"
                />
            </a>
            <div class="ml-auto box_user">
                <div class="dropdown dropdown_user">
                    <a class="dropdown_user" v-bind:id="[!homePage ? 'dropdown_user': '']" href="javascript:void(0)" v-on:click="dropUser">
                        <img
                            src="/assets/images/svg/i_user.svg" 
                            alt="" 
                            class="img-fluid"
                            v-bind:class="[homeWhiteClass]" 
                            width="15" />
                        <img 
                            src="/assets/images/svg/i_user_black.svg"
                            alt=""
                            class="img-fluid"
                            v-bind:class="[homeBlackClass]"
                            width="15"
                        />
                        <span v-if="userName">ログイン中</span>
                        <span v-else>ログイン</span>
                    </a>
                    <div class="dropdown_user_content" style="display: none;">
                        <ul>
                            <!-- <li>
                                <a href="javascript:void(0)" v-if="userName">{{ userName }}様</a>
                            </li> -->
                            <li>
                                <a href="/customer/information">会員登録情報</a>
                            </li>
                            <li><a href="/customer/announcement-condition">メルマガ配信希望条件</a></li>
                            <!-- <li>
                                <a href="/notice"
                                    >お知らせ <span v-if="announcementCount != 0">{{ announcementCount }}</span></a
                                >
                            </li> -->
                            <li><a href="/wishlist">お気に入り</a></li>
                            <li><a href="javascript:void(0)" v-on:click="logout">ログアウト</a></li>
                        </ul>
                    </div>
                </div>

                <div class="dropdown dropdown_search">
                    <a id="dropdown_search" href="#" v-on:click="dropSearch">
                        <img
                            src="/assets/images/svg/i_search.svg"
                            alt=""
                            class="img-fluid"
                            v-bind:class="[homeWhiteClass]"
                            width="16"
                        />
                        <img
                            src="/assets/images/svg/i_search_black.svg"
                            alt=""
                            class="img-fluid"
                            v-bind:class="[homeBlackClass]"
                            width="16"
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
                                        >
                                            <img
                                                src="/images/svg/i_map_black.svg"
                                                alt=""
                                                class="img-fluid"
                                                width="18"
                                            />
                                            エリアから探す
                                        </button>
                                    </h2>
                                </div>

                                <div
                                    id="collapseOne"
                                    ref="collapseArea"
                                    class="collapse show"
                                    aria-labelledby="headingOne"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body districts">
                                        <ul>
                                            <li v-for="district in districtList" :key="district.id">
                                                <a
                                                    href="javascript:void(0)"
                                                    v-on:click="searchDistrict(district.name, district.code)"
                                                    >{{ district.name }}</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
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
                                        >
                                            <img
                                                src="/assets/images/svg/i_stations_black.svg"
                                                alt=""
                                                class="img-fluid"
                                                width="13"
                                            />
                                            <span>沿線から探す</span>
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapseTwo"
                                    ref="collapseStation"
                                    class="collapse"
                                    aria-labelledby="headingTwo"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body stations">
                                        <ul>
                                            <li v-for="company in transportCompanyList" :key="company.tran_company_code">
                                                <a
                                                    class="station-item"
                                                    href="javascript:void(0)"
                                                    v-on:click="searchStation(company.tran_company_short_name, company.tran_company_code)"
                                                    >{{ company.tran_company_short_name }}</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
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
                            <!-- <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-block text-left collapsed"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapseThree"
                                            aria-expanded="false"
                                            aria-controls="collapseThree"
                                        >
                                            <img
                                                src="/assets/images/svg/i_locations_black.svg"
                                                alt=""
                                                class="img-fluid"
                                                width="14"
                                            />
                                            <span>MAPから探す</span>
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapseThree"
                                    class="collapse"
                                    aria-labelledby="headingThree"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">足立区</a></li>
                                            <li><a href="">荒川区</a></li>
                                            <li><a href="">板橋区</a></li>
                                            <li><a href="">江戸川区</a></li>
                                            <li><a href="">大田区</a></li>
                                            <li><a href="">葛飾区</a></li>
                                            <li><a href="">北区</a></li>
                                            <li><a href="">江東区</a></li>
                                            <li><a href="">品川区</a></li>
                                            <li><a href="">渋谷区</a></li>
                                            <li><a href="">新宿区</a></li>
                                            <li><a href="">杉並区</a></li>
                                            <li><a href="">墨田区</a></li>
                                            <li><a href="">世田谷区</a></li>
                                            <li><a href="">台東区</a></li>
                                            <li><a href="">千代田区</a></li>
                                            <li><a href="">中央区</a></li>
                                            <li><a href="">豊島区</a></li>
                                            <li><a href="">中野区</a></li>
                                            <li><a href="">練馬区</a></li>
                                            <li><a href="">文京区</a></li>
                                            <li><a href="">港区</a></li>
                                            <li><a href="">目黒区</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </nav>
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
            logoBlack: logoBlack,
            userName: '',
            districtList: {},
            stationList: {},
            transportCompanyList: {},
            announcementCount: 0,
            homePage: true, 
            homeWhiteClass: '',
            homeBlackClass: '',
            isScroll: false,
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

        this.getStation();
        this.getTransportCompany();
        this.getDistrict();

        // LSMEvent.$on('handleSeachClick', type => {
        //     this.dropSearchByType(type);
        // });

        this.userName = this.$getLocalStorage('userName');
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
                .catch(error => {});
        },

        dropUser(event) {
            this.$store.dispatch('customerInfo').then(resp => {
                    event.preventDefault();
                    $('.dropdown_user_content').slideToggle('fast');
                    $('.dropdown_search_content').hide();
                    this.announcementCount = this.$getCookie('announcement_count');
                }).catch((err) => {
                    this.$setCookie('accessToken3d', '', 1);
                    this.$removeAuthLocalStorage();
                    this.$removeLocalStorage('announcement_count');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.push({ name: 'login' }).catch(() => {});
                });
        },

        dropSearch(event) {
            event.preventDefault();
            $('.dropdown_search_content').slideToggle('fast');
            $('.dropdown_user_content').hide();
        },

        closeSearch() {
            $('.dropdown_user_content').hide();
            $('.dropdown_search_content').hide();
        },

        // dropSearchByType(type = 'area') {
        //     $('.dropdown_search_content').slideToggle('fast');
        //     $('.dropdown_user_content').hide();
        //     switch (type) {
        //         case 'station':
        //             if (!this.$refs.collapseStation.classList.contains('show')) {
        //                 this.$refs.showStation.click();
        //             }
        //             break;
        //         case 'area':
        //         default:
        //             if (!this.$refs.collapseArea.classList.contains('show')) {
        //                 this.$refs.showArea.click();
        //             }
        //             break;
        //     }
        // },

        scrollListener() {
            if (window.pageYOffset > 0) {
                this.isScroll = true;
            } else {
                this.isScroll = false;
            }
        },

        getDistrict() {
            this.$store.dispatch('getDistrict').then(response => {
                this.districtList = response.data;
            });
        },

        getStation() {
            this.$store.dispatch('getStation').then(response => {
                this.stationList = response;
            });
        },
        getTransportCompany() {
            this.$store.dispatch('getTransportCompany').then(response => {
                this.transportCompanyList = response;
            });
        },

        searchDistrict(districtName, code) {
            let cookieStation = this.$getLocalStorage('station');
            if (cookieStation) {
                this.$removeLocalStorage('station');
            }
            this.$setLocalStorage('district', districtName);
            this.$router
                // .push({ name: 'list'})
                .push({ name: 'listByCode', params: {searchCode: code} })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        searchStation(companyName, companyCode) {
            let cookieDistrict = this.$getLocalStorage('district');
            if (cookieDistrict) {
                this.$removeLocalStorage('district');
            }
            this.$setLocalStorage('station', companyName);
            this.$router
                .push({ name: 'listByCode', params: {searchCode: companyCode} })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        }
    }
};
</script>
