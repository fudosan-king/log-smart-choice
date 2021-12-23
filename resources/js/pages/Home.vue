<template>
    <main>
        <section class="section_banner" style="background-image: url('/assets/images/slideshow/slide-1.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="200" height="200" />
            </div>
            <p>まだ見ぬ住まいとの出会いを演出</p>
            <div class="top_action">
                <ul>
                    <li>
                        <a class="btn_map search-district" v-on:click="handleHeaderContentClick('district', $event)">
                            <span>リノベ物件から探す</span>
                        </a>
                    </li>
                    <li>
                        <a class="btn_stations search-station" v-on:click="handleHeaderContentClick('station', $event)">
                            <span>リノベテイストから探す</span>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="section_near_property">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="top_info">
                            <div class="top_brand">
                                <img
                                    class="img-fluid"
                                    src="/assets/images/common/logo-orderrenove.svg"
                                    alt=""
                                    title=""
                                />
                            </div>
                            <h3>提案型リノベーションプラットフォーム</h3>
                            <p>
                                Order
                                Renoveは「リノベーション済み物件」だけでなく、まだ施工していない「リノベーション向き物件」まで紹介していきます。まだ物件数が少ない「リノベーション済み物件」だけでなく、「中古物件＋リノベーション」を視野に入れることで、人々の住まいにおける選択肢を増やし、ユーザーに最適な住まいを提案していきます。
                            </p>
                        </div>
                        <estates-top-component></estates-top-component>
                        <button type="button" class="btn btn-load-more" v-on:click="clearConditionSearch">
                            もっと見る
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_near_property bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <!-- <h2 class="title"><b>おすすめ物件</b></h2> -->
                        <!-- <estates-near-component></estates-near-component> -->
                        <!-- <estate-recommend-component></estate-recommend-component> -->

                        <!-- <p class="text-center mt-3">
                            <a v-on:click="clearConditionSearch" class="btn btnSeemore"><b>もっと見る</b></a>
                        </p> -->
                    </div>
                </div>
            </div>
        </section>

        <section class="p-0">
            <div class="top-lists">
                <div class="top_item">
                    <div class="container">
                        <div class="top_item-ct">
                            <div class="top_logo">
                                <img class="img-fluid" src="/assets/images/common/logo-logrenove.svg" alt="" title="" />
                            </div>
                            <p class="logan">
                                LogRenove Premium<br />
                                Produced by LogRenove
                            </p>
                            <div class="top_group">
                                <div class="top_img">
                                    <img class="img-fluid" src="/assets/images/top-page/top-img.jpg" alt="" title="" />
                                </div>

                                <p class="style">Style 01</p>
                                <h2>
                                    木の香に包まれた<br />
                                    無垢材リノベStyle
                                </h2>
                                <p>
                                    フローリングはもちろん、ドア、洗面、キッチンに至るまで、すべて天然木で埋め尽くしたユニークな定額ノベーション。都市で暮らす私たちが忘れかけていた、ナチュラルな生活を味わえるプランです。
                                </p>
                                <ul>
                                    <li>
                                        <a href="#">無垢材</a>
                                    </li>
                                    <li>
                                        <a href="#">定額リノベーション</a>
                                    </li>
                                    <li>
                                        <a href="#">LogRenove</a>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-detail">DETAIL</a>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-img">
                        <div class="bottom-img_left">
                            <img class="img-fluid" src="/assets/images/top-page/img-bottom-1.png" alt="" />
                        </div>
                        <div class="bottom-img_right">
                            <img class="img-fluid" src="/assets/images/top-page/img-bottom.jpg" alt="" />
                        </div>
                        <div class="bottom-img_full">
                            <img class="img-fluid" src="/assets/images/top-page/img-bottom-1.jpg" alt="" />
                        </div>
                    </div>
                </div>

                <!-- <div class="top_item">
                        <div class="container">
                            <div class="top_item-ct">
                                <div class="top_logo">
                                    <img class="img-fluid" src="./images/common/logo-mukustyle.svg" alt="" title="">
                                </div>
                                <p class="logan">LogRenove Premium<br>
                                Produced by LogRenove</p>
                                <div class="top_group">
                                    <div class="top_img">
                                        <img class="img-fluid" src="./images/top-page/top-img.jpg" alt="" title="">
                                    </div>

                                    <p class="style">Style 02</p>
                                    <h2>無垢に暮らす。という選択</h2>
                                    <p>天然木が肌に馴染む、無垢な優しさに包まれる。</p>
                                    <p>家族が過ごす、仲間が集う。</p>
                                    <p>大人も子供も無邪気に笑う。</p>
                                    <ul>
                                        <li>
                                            <a href="#">無垢材</a>
                                        </li>
                                        <li>
                                            <a href="#">定額リノベーション</a>
                                        </li>
                                        <li>
                                            <a href="#">LogRenove</a>
                                        </li>
                                    </ul>
                                    <a href="#" class="btn btn-detail">DETAIL</a>
                                   
                                </div>
                            </div>
                        </div>
                    </div> -->

                <!--     
                    <div class="top_promotion">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="promotion_box">
                                        <div class="promotion_img">
                                            <img class="img-fluid" src="./images/top-page/top-promotion.png" alt="" title="">
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
                                            <img class="img-fluid" src="./images/top-page/top-promotion-1.png" alt="" title="">
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
                    </div>
                     -->
                <div class="top-more-info">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="more-info_item">
                                    <h3>サービス一覧</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <p>OrderRenoveについて</p>
                                            <!--    <p>リノベプラン一覧</p>
                                                <p>マネーシミュレータ</p>
                                                <p>売却サポート</p> -->
                                        </div>
                                        <div class="col-6">
                                            <p>物件一覧</p>
                                            <!-- <p>OrderRenove通信</p>
                                                <p>コンシェルジュ相談</p> -->
                                            <p>会員登録</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="more-info_item">
                                    <h3>エリアから探す</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                <!-- <a href="javascript:void(0)" v-on:click="searchList('世田谷区', 'area')"
                                                    >世田谷区 &nbsp;</a
                                                > -->
                                                <template v-for="district in districtList">
                                                    <a href="javascript:void(0)" v-on:click="searchList(district, 'area')">{{ district.name }} &nbsp;</a>
                                                </template>
                                                <!-- 表参道･青山　麻布･広尾　渋谷･恵比寿･中目黒　目黒･白金高輪　下北沢･三軒茶屋　東横線･目黒線　駒沢･二子玉川　代々木公園　井の頭線　神楽坂　品川・田町　銀座・築地　豊洲清澄・門前仲町　皇居西側　中央線　千駄ヶ谷･四ッ谷　西新宿　東新宿･早稲田　その他 -->
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="more-info_item">
                                    <h3>人気の駅から探す</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                <template v-for="station in stationList">
                                                    <a href="javascript:void(0)" v-on:click="searchList(station, 'station')">{{ station.name }} &nbsp;</a>
                                                </template>
                                                <!-- 表参道駅　乃木坂駅　目黒駅　中目黒駅　代官山駅　恵比寿駅　渋谷駅　三軒茶屋駅　広尾駅　麻布十番駅　六本木駅　品川駅　田町駅　五反田駅　大崎駅 -->
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="more-info_item">
                                    <h3>こだわりから探す</h3>
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
            </div>
        </section>
    </main>
</template>
<script>
import Lazyload from 'vue-lazyload';
import Vue from 'vue';
import PagePost from '../store/modules/page-post.js'

Vue.use(Lazyload, {
    preLoad: 1.3,
    error: 'images/no-image.png',
    loading: 'images/loading1.gif',
    attempt: 1
});
export default {
    data() {
        
        return {
            searchType: '',
            tabList: '',
            stationList: '',
            districtList: '',
            routerList: [],
        };
    },
    created() {
        this.$store.registerModule('page-post', PagePost)
    },
    beforeDestroy() {
        this.$store.unregisterModule('page-post');
    },
    components: {
        EstatesTopComponent: () => import('../components/EstatesTopComponent'),
        EstateRecommendComponent: () => import('../components/EstateRecommendComponent'),
        EstatesNearComponent: () => import('../components/EstatesNearComponent')
    },
    mounted() {
        this.getTabList();
        this.getStaionHardCode();
        this.getDistrictHardCode();
        this.pushRouterToServer();
    },
    methods: {
        clearConditionSearch() {
            this.$removeLocalStorage('district');
            this.$removeLocalStorage('station');
            this.$router.push('list').catch(() => {});
        },
        handleHeaderContentClick(type = 'district', event) {
            if (type == 'district') {
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

        handleCloseSearch() {
            this.searchType = '';
        },

        getTabList() {
            this.$store.dispatch('getTabList').then(response => {
                this.tabList = response;
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

        getStaionHardCode() {
            this.$store.dispatch('getStationsHardCodeSearch').then(response => {
                this.stationList = response;
            });
        },

        getDistrictHardCode() {
            this.$store.dispatch('getDistrictsHardCodeSearch').then(response => {
                this.districtList = response;
            });
        },

        pushRouterToServer() {
            let routerList = [];
            this.$router.options.routes.forEach(route => {
                routerList.push({
                    name: route.name
                })
            })
            this.$store.dispatch('updatePagePost', routerList).then().catch();
        }
    }
};
</script>
