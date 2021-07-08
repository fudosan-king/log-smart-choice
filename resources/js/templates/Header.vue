<template>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <a class="navbar-brand" href="/">
                <img
                    src="/assets/images/svg/logo_orderrenove_white.svg"
                    alt=""
                    class="img-fluid white-logo i_white"
                    width="224"
                />
                <img
                    src="/assets/images/svg/logo_orderrenove_black.svg"
                    alt=""
                    class="img-fluid black-logo i_black"
                    width="134"
                />
            </a>
            <div class="ml-auto box_user">
                <div class="dropdown dropdown_user mr-3">
                    <a class="dropdown_user drop-user" href="javascript:void(0)" v-on:click="dropUser">
                        <img src="/assets/images/svg/i_user.svg" alt="" class="img-fluid icon-user-white" width="15" />
                        <img
                            src="/assets/images/svg/i_user_black.svg"
                            alt=""
                            class="img-fluid icon-user-black"
                            width="15"
                        />
                        <span v-if="userName">{{ userName }}様</span>
                        <span v-else>ログイン</span>
                    </a>
                    <div class="dropdown_user_content" style="display: none;">
                        <ul>
                            <li>
                                <a href="javascript:void(0)" v-if="userName">{{ userName }}様</a>
                            </li>
                            <li>
                                <a href="/customer/information">会員登録情報</a>
                            </li>
                            <li><a href="/customer/announcement-condition">メルマガ配信希望条件</a></li>
                            <li>
                                <a href="/notice"
                                    >お知らせ <span v-if="announcementCount != 0">{{ announcementCount }}</span></a
                                >
                            </li>
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
                            class="img-fluid icon-search-white"
                            width="16"
                        />
                        <img
                            src="/assets/images/svg/i_search_black.svg"
                            alt=""
                            class="img-fluid icon-search-black"
                            width="16"
                        />
                    </a>
                    <div class="dropdown_search_content" style="display: none;">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-block text-left"
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
                                            <li v-for="district in districtList">
                                                <a
                                                    href="javascript:void(0)"
                                                    v-on:click="searchDistrict(district.name)"
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
                                            沿線から探す
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
                                            <li v-for="station in stationList">
                                                <a
                                                    class="station-item"
                                                    href="javascript:void(0)"
                                                    v-on:click="searchStation(station)"
                                                    >{{ station }}</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
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
                                            MAPから探す
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
            announcementCount: 0
        };
    },
    mounted() {
        window.addEventListener('scroll', this.scrollListener);
        let compressHeaders = ['home', 'announcementCondition'];
        let subHeader = ['announcementCondition'];
        if (!compressHeaders.includes(this.$route.name)) {
            $('header').addClass('compressed');
        }
        if (subHeader.includes(this.$route.name)) {
            $('header').addClass('subheader');
            $('.white-logo').addClass('d-none');
            $('.icon-user-white').addClass('d-none');
            $('.icon-search-white').addClass('d-none');
            $('.drop-user').css('border-color', '#000');
            $('.drop-user').css('border', '1px solid');
            $('.drop-user').css('color', '#000');
        }

        if (this.$route.name == 'home') {
            $('.black-logo').addClass('d-lg-none');
            $('.icon-user-black').addClass('d-lg-none');
            $('.icon-search-black').addClass('d-lg-none');
        }

        this.getStation();
        this.getDistrict();

        LSMEvent.$on('handleSeachClick', type => {
            this.dropSearchByType(type);
        });

        this.userName = this.$getCookie('userName');
    },
    methods: {
        logout() {
            this.$store
                .dispatch('logout')
                .then(response => {
                    this.$setCookie('accessToken', '', 1);
                    this.$setCookie('accessToken3d', '', 1);
                    this.$setCookie('userName', '', 1);
                    this.$setCookie('userEmail', '', 1);
                    this.$setCookie('userSocialId', '', 1);
                    this.$setCookie('district', '', 1);
                    this.$setCookie('station', '', 1);
                    this.$setCookie('announcement_count', '', 1);
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go(0);
                })
                .catch(error => {});
        },

        dropUser(event) {
            let accessToken = this.$getCookie('accessToken');
            // this.userName = this.$getCookie('userName');
            this.announcementCount = this.$getCookie('announcement_count');
            if (accessToken != '') {
                event.preventDefault();
                $('.dropdown_user_content').slideToggle('fast');
                $('.dropdown_search_content').hide();
            } else {
                this.$router.push({ name: 'login' }).catch(() => {});
            }
        },

        dropSearch(event) {
            event.preventDefault();
            $('.dropdown_search_content').slideToggle('fast');
            $('.dropdown_user_content').hide();
        },

        dropSearchByType(type = 'area') {
            $('.dropdown_search_content').slideToggle('fast');
            $('.dropdown_user_content').hide();
            switch (type) {
                case 'station':
                    if (!this.$refs.collapseStation.classList.contains('show')) {
                        this.$refs.showStation.click();
                    }
                    break;
                case 'area':
                default:
                    if (!this.$refs.collapseArea.classList.contains('show')) {
                        this.$refs.showArea.click();
                    }
                    break;
            }
        },

        scrollListener() {
            let compressHeaders = ['home', 'announcementCondition'];
            if (compressHeaders.includes(this.$route.name)) {
                if (window.pageYOffset > 0) {
                    $('header').addClass('compressed');
                } else {
                    $('header').removeClass('compressed');
                }
            }

            let useDiffrenceHeader = ['announcementCondition'];

            if (useDiffrenceHeader.includes(this.$route.name)) {
                if (window.pageYOffset > 0) {
                    $('.white-logo').removeClass('d-none');
                    $('.icon-user-white').removeClass('d-none');
                    $('.icon-search-white').removeClass('d-none');
                    $('.black-logo').addClass('d-none');
                    $('.icon-user-black').addClass('d-lg-none');
                    $('.icon-search-black').addClass('d-lg-none');
                    $('.drop-user').css('border-color', 'white');
                    $('.drop-user').css('border', '1px solid');
                    $('.drop-user').css('color', 'white');
                } else {
                    $('.black-logo').removeClass('d-none');
                    $('.icon-user-black').removeClass('d-lg-none');
                    $('.icon-search-black').removeClass('d-lg-none');
                    $('.white-logo').addClass('d-none');
                    $('.icon-user-white').addClass('d-none');
                    $('.icon-search-white').addClass('d-none');
                    $('.drop-user').css('border-color', '#000');
                    $('.drop-user').css('border', '1px solid');
                    $('.drop-user').css('color', '#000');
                }
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

        searchDistrict(district) {
            let cookieStation = this.$getCookie('station');
            if (cookieStation.length > 0) {
                this.$setCookie('station', '', 1);
            }
            this.$setCookie('district', district, 1);
            this.$router
                .push({ name: 'list' })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        searchStation(station) {
            let cookieDistrict = this.$getCookie('district');
            if (cookieDistrict.length > 0) {
                this.$setCookie('district', '', 1);
            }
            this.$setCookie('station', station, 1);
            this.$router
                .push({ name: 'list' })
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
