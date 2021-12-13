<template>
    <main id="main">
        <section class="section_banner" style="background-image: url('/assets/images/takayamatei-800x534.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="200" height="200" />
                <p>まだ見ぬ住まいとの出会いを演出</p>
            </div>
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
                                <img class="img-fluid" src="/assets/images/common/logo-orderrenove.svg" alt="" title="" />
                            </div>
                            <h3>提案型リノベーションプラットフォーム</h3>
                            <p>
                                Order
                                Renoveは「リノベーション済み物件」だけでなく、まだ施工していない「リノベーション向き物件」まで紹介していきます。まだ物件数が少ない「リノベーション済み物件」だけでなく、「中古物件＋リノベーション」を視野に入れることで、人々の住まいにおける選択肢を増やし、ユーザーに最適な住まいを提案していきます。
                            </p>
                        </div>
                        <estates-top-component></estates-top-component>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_near_property bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2 class="title"><b>おすすめ物件</b></h2>
                        <!-- <estates-near-component></estates-near-component> -->
                        <estate-recommend-component></estate-recommend-component>
                        <p class="text-center mt-3">
                            <a v-on:click="clearConditionSearch" class="btn btnSeemore"><b>もっと見る</b></a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
<script>
import Lazyload from 'vue-lazyload';
import Vue from 'vue';

Vue.use(Lazyload, {
    preLoad: 1.3,
    error: 'images/no-image.png',
    loading: 'images/loading1.gif',
    attempt: 1
});
export default {
    data() {
        return {
            searchType: ''
        };
    },
    components: {
        EstatesTopComponent: () => import('../components/EstatesTopComponent'),
        EstateRecommendComponent: () => import('../components/EstateRecommendComponent'),
        EstatesNearComponent: () => import('../components/EstatesNearComponent')
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
        }
    }
};
</script>
