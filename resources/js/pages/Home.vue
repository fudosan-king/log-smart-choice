<template>
    <main>
        <section class="section_banner" style="background-image: url('/assets/images/slideshow/slide-1.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="200" height="200" />
            </div>
            <p>ラグジュアリーリノベ物件に住まう</p>
            <div class="top_action">
                <ul>
                    <li>
                        <a class="btn_map search-district" v-on:click="handleHeaderContentClick('district')">
                            <span>物件を探す</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a class="btn_stations search-station" href="/concept">
                            <span>リノベテイストから探す</span>
                        </a>
                    </li> -->
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
                                    width="60px"
                                    height="43px"
                                />
                            </div>
                            <h3>大手ポータルサイト未掲載の物件多数</h3>
                            <p>
                                Order
                                Renoveは「リノベーション済み物件」だけでなく、まだ施工していない「リノベーション向き物件」まで幅広く紹介していきます。しかも大手の不動産ポータルサイトには掲載していない希少な物件が大多数です。人々の住まいにおける選択肢を増やし、ユーザーに最適な住まいを提案していきます。
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

        <!-- <section class="section_near_property bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2 class="title"><b>おすすめ物件</b></h2>
                        <estates-near-component></estates-near-component>
                        <estate-recommend-component></estate-recommend-component>

                        <p class="text-center mt-3">
                            <a v-on:click="clearConditionSearch" class="btn btnSeemore"><b>もっと見る</b></a>
                        </p>
                    </div>
                </div>
            </div>
        </section> -->

        <section class="p-0">
            <div class="top-lists">
                <template v-for="post in posts">
                    <div class="top_item">
                        <div class="container">
                            <div class="top_item-ct">
                                <div class="top_logo">
                                    <img
                                        v-lazy="post.title_image ? post.title_image : '/images/no-image.png'"
                                        alt=""
                                        class="img-fluid"
                                        width="216"
                                        height="40"
                                    />
                                </div>
                                <p class="logan">
                                    {{ post.title }}<br />
                                    {{ post.title_signal }}
                                </p>
                                <div class="top_group">
                                    <div class="top_img">
                                        <img
                                            v-lazy="post.top_image ? post.top_image : '/images/no-image.png'"
                                            alt=""
                                            class="img-fluid"
                                            width="690"
                                            height="520"
                                        />
                                    </div>

                                    <template>
                                        <div v-html="post.content"></div>
                                    </template>
                                    <!-- <p class="style">Style 01</p>
                                    <h2>
                                        木の香に包まれた<br />
                                        無垢材リノベStyle
                                    </h2>
                                    <p>
                                        フローリングはもちろん、ドア、洗面、キッチンに至るまで、すべて天然木で埋め尽くしたユニークな定額ノベーション。都市で暮らす私たちが忘れかけていた、ナチュラルな生活を味わえるプランです。
                                    </p> -->
                                    <ul>
                                        <li v-for="tag in post.tag_posts">
                                            <a href="#">{{ tag.name }}</a>
                                        </li>
                                    </ul>
                                    <div class="group_box">
                                        <a href="/plan/detail" class="btn btn-detail">DETAIL</a>
                                        <a :href="'/plan/contact/' + post.id" class="btn btn-detail"
                                            >資料請求・お問い合わせ</a
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-img">
                            <template v-for="(images, index) in post.post_images">
                                <div :class="images.class_css">
                                    <img
                                        v-lazy="images.image_url ? images.image_url : '/images/no-image.png'"
                                        alt=""
                                        class="img-fluid"
                                        :width="index == 0 ? 335 : index == 1 ? 260 : 490"
                                        :height="index == 0 ? 300 : index == 1 ? 260 : 320"
                                    />
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                <div class="top-more-info top-more-bg"></div>
            </div>
        </section>
    </main>
</template>
<script>
import Lazyload from 'vue-lazyload';
import Vue from 'vue';
import PagePost from '../store/modules/page-post.js';

Vue.use(Lazyload, {
    preLoad: 1.3,
    error: 'images/no-image.png',
    loading: 'images/loading1.gif',
    attempt: 1
});
export default {
    created() {
        this.$store.registerModule('page-post', PagePost);
    },
    beforeDestroy() {
        this.$store.unregisterModule('page-post');
    },
    data() {
        return {
            searchType: '',
            routerList: [],
            posts: ''
        };
    },
    updated() {
        $('.top_item').each(function(i, ele) {
            if (
                $(ele)
                    .find('.bottom-img')
                    .children().length < 3
            ) {
                $(ele).addClass('changed');
            }
        });
    },
    created() {
        this.$store.registerModule('page-post', PagePost);
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
        this.pushRouterToServer();
        this.getPosts();
    },
    methods: {
        clearConditionSearch() {
            this.$removeLocalStorage('district');
            this.$removeLocalStorage('station');
            this.$removeLocalStorage('conditionSearch');
            this.$removeLocalStorage('idParent');
            this.$router.push('list').catch(() => {});
        },

        handleHeaderContentClick(type) {
            if (type == 'district') {
                this.$setLocalStorage('tabActive', 'area');
            } else {
                this.$setLocalStorage('tabActive', 'station');
            }

            this.$router
                .push('search')
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

        pushRouterToServer() {
            let routerList = [];
            this.$router.options.routes.forEach(route => {
                routerList.push({
                    name: route.name
                });
            });
            this.$store
                .dispatch('updatePagePost', routerList)
                .then()
                .catch();
        },

        getPosts() {
            let data = {
                page_post: this.$route.name
            };
            this.$store.dispatch('getPosts', data).then(response => {
                this.posts = response;
            });
        }
    },
    metaInfo: {
        titleTemplate: 'リノベーションプラットフォーム「オーダーリノベ」｜Order Renove',
        meta: [
            {
                description:
                    'Order Renove（オーダーリノベ）は都内を中心に、「リノベーション済物件」「リノベーション向き物件」を多数掲載。大手ポータル未掲載の物件も多数そろえています。'
            }
        ]
    }
};
</script>
