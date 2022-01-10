<template>
    <div>
        <section class="section_banner" style="background-image: url('/assets/images/slideshow/slide-1.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="200" height="200" />
            </div>
            <p>テイストと予算で選べる<br>
                定額リノベーションプラン</p>
                <h3>価格、立地、広さ…条件にあった中古マンションを<br>好みのテイストでリノベーションする醍醐味</h3>
        </section>
        <section class="section_near_property">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="rnv-explain">
                            <div class="container">
                                <p class="sm-title">CONCEPT</p>
                                <h2>
                                    中古マンション＋定額リノベ<br />
                                    で理想の住まいを手に入れる
                                </h2>
                                <div class="plan_info">
                                    <p>
                                        中古マンションを購入してリノベーションする場合、最終的な施工金額と仕上がりイメージがわかりにくいのが難点とされてきました。そこでOrder
                                        Renoveは、金額と仕上がりイメージが具体的にわかる「定額リノベーションプラン」を複数ご用意いたしました。希望の価格、立地、広さの物件に、好みのリノベーションプランをかけ合わせて、理想の住まいを「不安なく」「賢く」「自分らしく」手にいれましょう。
                                    </p>
                                    <!-- <p>
                                        周辺には植え込みのあるスタイリッシュな建物が多く、緑を目にすることが可能です。
                                    </p> -->
                                </div>
                                <div class="plan_img">
                                    <img class="img-fluid" src="/assets/images/concept/concept.png" alt="" title="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                    <a href="/plan/detail" class="btn btn-detail">DETAIL</a>
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
            </div>
        </section>
    </div>
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
    data() {
        return {
            posts: ''
        };
    },
    created() {
        this.$store.registerModule('page-post', PagePost);
    },
    beforeDestroy() {
        this.$store.unregisterModule('page-post');
    },
    mounted() {
        this.getPost();
    },
    methods: {
        getPost() {
            let data = {
                page_post: this.$route.name
            };
            this.$store.dispatch('getPost', data).then(response => {
                this.posts = response;
            });
        }
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
};
</script>
