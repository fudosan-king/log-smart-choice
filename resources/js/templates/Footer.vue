<template>
    <div>
        <!-- <div class="top_promotion">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="promotion_box">
                            <div class="promotion_img">
                                <img
                                    class="img-fluid"
                                    src="/assets/images/top-page/top-promotion.png"
                                    alt=""
                                    title=""
                                />
                            </div>
                            <div class="promotion_info">
                                <h3>マネー診断シミュレータ</h3>
                                <p>ライフプランに応じた物件価格を診断</p>
                                <div class="promotion_btn">
                                    <a href="#">シミュレーション</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="promotion_box">
                            <div class="promotion_img">
                                <img
                                    class="img-fluid"
                                    src="/assets/images/top-page/top-promotion-1.png"
                                    alt=""
                                    title=""
                                />
                            </div>
                            <div class="promotion_info">
                                <h3>コンシェルジュ相談</h3>
                                <p>ニーズに応じた理想の住まいをご提案</p>
                                <div class="promotion_btn">
                                    <a href="#">相談する</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="space_div"></div>
        <div class="top-more-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h2>サービス一覧</h2>
                            <div class="row">
                                <div class="col-6">
                                    <p><a href="/about">OrderRenoveについて</a></p>
                                    <p><a href="/concept">リノベプラン一覧</a></p>
                                    <!-- <p>マネーシミュレータ</p>
                                    <p>売却サポート</p> -->
                                </div>
                                <div class="col-6">
                                    <p><a href="/list">物件一覧</a></p>
                                    <p><a href="/fast-register">OrderRenove通信</a></p>
                                    <p><a href="/register">会員登録</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- District -->
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h2>エリアから探す</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <template v-for="district in districtList">
                                            <a href="javascript:void(0)" v-on:click="searchList(district, 'area')"
                                                >{{ district.name }} &nbsp;</a
                                            >
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End District -->

                    <!-- Station -->
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h2>人気の駅から探す</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <template v-for="station in stationList">
                                            <a href="javascript:void(0)" v-on:click="searchList(station, 'station')"
                                                >{{ station.name }} &nbsp;</a
                                            >
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Station -->

                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h2>こだわりから探す</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <template v-for="tag in tabList">
                                            <a href="javascript:void(0)" v-on:click="searchList(tag, 'tag')">{{
                                                tag.name
                                            }}</a>
                                            &nbsp;
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer_top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <p class="text-center mb-4">
                                <a class="logo_footer" href="index.php"
                                    ><img
                                        src="/images/svg/logo_orderrenove_white.svg"
                                        alt=""
                                        class="img-fluid"
                                        width="224"
                                        height="224"
                                /></a>
                            </p>
                            <ul class="text-center">
                                <li><a target="_blank" href="https://form.run/@order-renove">お問い合わせ</a></li>
                                <li>
                                    <a target="_blank" href="https://www.logsuite.co.jp/policy/"
                                        >プライバシーポリシー</a
                                    >
                                </li>
                                <li>
                                    <a target="_blank" href="https://www.logsuite.co.jp/socialmedia-policy/"
                                        >ソーシャルメディアポリシー</a
                                    >
                                </li>
                                <li><a target="_blank" href="https://www.propolife.co.jp/terms/"> 利用規約</a></li>
                                <li><a target="_blank" href="https://www.logknot.co.jp/">運営会社（企業情報）</a></li>
                                <li>
                                    <a target="_blank" href="https://www.propolife.co.jp/antisocial/"
                                        >反社会的勢力排除に関する基本方針</a
                                    >
                                </li>
                            </ul>

                            <hr />

                            <ul class="footer_logo">
                                <li>
                                    <a target="_blank" href="https://www.logsuite.co.jp"
                                        ><img src="/images/svg/logSuite2_white.svg" alt="" class="img-fluid" width="88" height="88"
                                    /></a>
                                </li>
                                <li>
                                    <a target="_blank" href="https://www.logarchitects.co.jp"
                                        ><img src="/images/svg/logArch2_white.svg" alt="" class="img-fluid" width="120" height="120"
                                    /></a>
                                </li>
                                <li>
                                    <a target="_blank" href="https://www.logknot.co.jp"
                                        ><img src="/images/svg/logKnot2_white.svg" alt="" class="img-fluid" width="84" height="84"
                                    /></a>
                                </li>
                            </ul>
                            <p class="text-center">
                                <small
                                    >Copyright © <a target="_blank" href="https://www.logsuite.co.jp">LogSuite.</a> All
                                    Rights Reserved.</small
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom fixed-bottom" v-if="contactPart == 'detail'">
                <div class="bottom_box">
                    <a class="btn btn-ft button-contact" href="javascript:void(0)" v-on:click="directToContact"
                        ><img
                            src="/assets/images/svg/i_mail.svg"
                            alt=""
                            class="img-fluid"
                            width="18"
                            height="18"
                        />内覧・お問い合わせ</a
                    >
                    <a class="btn btn-ft button-contact" href="tel:0120991657"
                        ><img
                            src="/assets/images/svg/i_call.svg"
                            alt=""
                            class="img-fluid"
                            width="18"
                            height="18"
                        />0120-991-657</a
                    >
                </div>
            </div>
            <div
                class="footer_bottom fixed-bottom align-center"
                v-if="routeName == 'home' || routeName == 'listByCode' || routeName == 'list'"
            >
                <!-- <template v-if="routeName != 'home'"> -->
                <a class="btn btn-ft button-contact" href="https://form.run/@order-renove" target="_blank"
                    ><img
                        src="/assets/images/svg/i_mail.svg"
                        alt=""
                        class="img-fluid"
                        width="18"
                        height="18"
                    />内覧・お問い合わせ
                </a>
                <!-- </template> -->

                <!-- <a class="btn" href="/search">条件を絞って物件検索</a> -->
            </div>
            <div class="footer_bottom fixed-bottom" v-if="routeName == 'estateSearch'">
                <a class="btn btn-ft" href="javascript:void(0)" v-on:click="resultSearch"
                    ><img
                        src="/assets/images/svg/i_search.svg"
                        alt=""
                        class="img-fluid"
                        width="18"
                        height="18"
                    />検索</a
                >
            </div>
        </footer>
    </div>
</template>
<script>
export default {
    components: {
        ScrollTopArrow: () => import('../components/ScrollTopComponent')
    },
    data() {
        const logoSliver = '/assets/images/SVG/logo_sliver.svg';
        const iLocationBlack = '/assets/images/SVG/i_location_black.svg';
        return {
            logoSliver: logoSliver,
            iLocationBlack: iLocationBlack,
            contactPart: '',
            tabList: '',
            stationList: '',
            districtList: ''
        };
    },
    mounted() {
        this.showContactPart();
        this.getTabList();
        this.getStaionHardCode();
        this.getDistrictHardCode();
    },
    methods: {
        showContactPart() {
            let urlContact = window.location.pathname.split('/');
            this.contactPart = urlContact[1];
        },
        directToContact() {
            let currentUrl = this.$route.path.split('/');
            let routeContact = this.$router.resolve({ name: 'contact' }).href;
            window.localStorage.setItem('estate_id', currentUrl[2]);
            if (this.$getLocalStorage('accessToken')) {
                window.open(window.location.origin + routeContact, '_blank');
            } else {
                this.contactWithOutLogin();
            }
        },

        contactWithOutLogin() {
            let currentUrl = this.$route.path.split('/');
            let routeContact = this.$router.resolve({ name: 'contact' }).href;
            this.$setCookie('estate_id', currentUrl[2], 1);
            window.open(window.location.origin + routeContact, '_blank');
        },

        floatButtonEvent() {
            let accessToken = this.$getLocalStorage('accessToken');
            if (accessToken) {
                this.$router.push({ name: 'announcementCondition' }).catch();
            } else {
                this.$router.push({ name: 'fastRegister' }).catch();
            }
        },

        resultSearch() {
            let districts = [],
                stations = [],
                flagSearch = 'station',
                idParents = [],
                tabList = [],
                tabListName = [],
                keyWord = [],
                parentIdSelected = [],
                parentNameSelected = [];

            if ($('#pills-area-tab').hasClass('active')) {
                $('input[name="inputDistrict[]"]:checked').each(function(i) {
                    idParents = [];
                    districts.push({
                        name: $(this).val(),
                        cityId: $(this).attr('data-city')
                    });
                    keyWord[i] = $(this).val();
                });
                $('.ck_allCity input:checked').each(function(i) {
                    idParents[i] = $(this).val();
                    parentIdSelected[i] = parseInt($(this).attr('data-id'));
                    parentNameSelected[i] = $(this).attr('data-name');
                });
                flagSearch = 'area';
            } else {
                $('input[name="inputStation[]"]:checked').each(function(i) {
                    idParents = [];
                    stations.push({
                        name: $(this).val(),
                        transportId: $(this).attr('data-transport')
                    });
                    keyWord[i] = $(this).val();
                });

                $('.ck_allStation input:checked').each(function(i) {
                    idParents[i] = $(this).val();
                    parentIdSelected[i] = parseInt($(this).attr('data-id'));
                    parentNameSelected[i] = $(this).attr('data-name');
                });
            }

            $('a[class="btn_commitment actived"]').each(function(i) {
                tabList[i] = $(this).data('id');
                tabListName[i] = $(this).data('value');
            });

            let minTotalPrice = $('select[name="minTotalPrices"]').val();
            let maxTotalPrice = $('select[name="maxTotalPrices"]').val();
            let minSquare = $('select[name="minSquare"]').val();
            let maxSquare = $('select[name="maxSquare"]').val();

            let data = {
                districts: districts,
                stations: stations,
                flagSearch: flagSearch,
                price: {
                    min: minTotalPrice,
                    max: maxTotalPrice
                },
                square: {
                    min: minSquare,
                    max: maxSquare
                },
                tabSesarch: tabList,
                tabName: tabListName
            };

            this.$setLocalStorage('tabActive', flagSearch);
            this.$setLocalStorage('conditionSearch', JSON.stringify(data));
            this.$setLocalStorage('idParents', JSON.stringify(idParents));
            this.$setLocalStorage('parentIdSelected', JSON.stringify(parentIdSelected));
            this.$setLocalStorage('parentNameSelected', JSON.stringify(parentNameSelected));

            this.$router
                .push({
                    name: 'list',
                    query: {
                        keyWord: keyWord,
                        minPrice: data.price.min,
                        maxPrice: data.price.max,
                        minSquare: data.square.min,
                        maxSquare: data.square.max,
                        tabSearchName: tabListName,
                        tabSearch: tabList
                    }
                })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        searchList(data, type) {
            let query = {
                minPrice: '下限なし',
                maxPrice: '上限なし',
                minSquare: '下限なし',
                maxSquare: '上限なし'
            };
            let dataConditionSearch = {
                districts: [],
                stations: [],
                tabSearch: query.tabSearchName,
                tabName: query.tabSearch
            };
            if (type == 'tag') {
                query.tabSearchName = data.name;
                query.tabSearch = data.id;
                this.$removeLocalStorage('idParents');
            } else if (type == 'station') {
                this.$setLocalStorage('tabActive', 'station');
                query.keyWord = data.name;
                dataConditionSearch.stations[0] = { name: data.name, transportId: data.transport_id };
            } else {
                this.$setLocalStorage('tabActive', 'area');
                query.keyWord = data.name;
                dataConditionSearch.districts[0] = { name: data.name, cityId: data.city_id };
            }

            this.$setLocalStorage('conditionSearch', JSON.stringify(dataConditionSearch));
            this.$router
                .push({
                    name: 'list',
                    query: query
                })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        getTabList() {
            this.$store.dispatch('getTabList').then(response => {
                this.tabList = response;
            });
        },

        getStaionHardCode() {
            this.$store.dispatch('getStationsHardCodeSearch').then(response => {
                this.stationList = response;
            });
        },

        getDistrictHardCode() {
            this.$store.dispatch('getDistrictsHardCodeSearch').then(response => {
                this.districtList = response;
            });
        }
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    }
};
</script>
