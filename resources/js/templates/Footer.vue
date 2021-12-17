<template>
    <footer>
        <div class="footer_top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <p class="text-center mb-4">
                            <a class="logo_footer" href="index.php"
                                ><img src="images/svg/logo_orderrenove_white.svg" alt="" class="img-fluid" width="224"
                            /></a>
                        </p>
                        <ul class="text-center">
                            <li><a target="_blank" href="https://www.logrenove.jp/contact/">お問い合わせ</a></li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/privacypolicy"
                                    >プライバシーポリシー</a
                                >
                            </li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/socialpolicy"
                                    >ソーシャルメディアポリシー</a
                                >
                            </li>
                            <li><a target="_blank" href="https://www.propolife.co.jp/terms"> 利用規約</a></li>
                            <li><a target="_blank" href="https://www.propolife.co.jp">運営会社（企業情報）</a></li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/antisocial"
                                    >反社会的勢力排除に関する基本方針</a
                                >
                            </li>
                        </ul>

                        <hr />

                        <p class="text-center">
                            <a target="_blank" href="https://www.logrenove.jp"
                                ><img src="images/svg/logrenove_logo.svg" alt="" class="img-fluid" width="108"
                            /></a>
                        </p>
                        <ul class="footer_logo">
                            <li>
                                <a target="_blank" href="https://www.logsuite.co.jp"
                                    ><img src="images/svg/logSuite2_white.svg" alt="" class="img-fluid" width="88"
                                /></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.logarchitects.co.jp"
                                    ><img src="images/svg/logArch2_white.svg" alt="" class="img-fluid" width="120"
                                /></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.logknot.co.jp"
                                    ><img src="images/svg/logKnot2_white.svg" alt="" class="img-fluid" width="84"
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
            <a class="btn" href="javascript:void(0)" v-on:click="directToContact"
                ><img
                    src="/assets/images/svg/i_mail.svg"
                    alt=""
                    class="img-fluid"
                    width="18"
                    height="18"
                />資料請求・内見</a
            >
            <a class="btn" href="tel:0120991657"
                ><img
                    src="/assets/images/svg/i_call.svg"
                    alt=""
                    class="img-fluid"
                    width="18"
                    height="18"
                />0120-991-657</a
            >
        </div>
        <div
            class="footer_bottom fixed-bottom align-center"
            v-if="routeName == 'home' || routeName == 'listByCode' || routeName == 'list'"
        >
            <!-- <template v-if="routeName != 'home'"> -->
            <a class="btn btn-ft" href="/contact"
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
        <div class="footer_bottom fixed-bottom" v-if="routeName == 'EstateSearch'">
            <a class="btn btn_conditions btn_search_conditions" href="javascript:void(0)" v-on:click="resultSearch"
                ><img src="/assets/images/svg/i_search.svg" alt="" class="img-fluid" width="18" height="18" />検索</a
            >
        </div>
    </footer>
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
            contactPart: ''
        };
    },
    mounted() {
        this.showContactPart();
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
            let districts = [];
            let stations = [];
            let flagSearch = 'station';
            let idParents = [];
            let tabList = [];
            let tabListName = [];
            let keyWord = [];
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
        }
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    }
};
</script>
