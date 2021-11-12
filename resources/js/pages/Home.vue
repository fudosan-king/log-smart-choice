<template>
    <main id="main">
        <section class="section_banner" style="background-image: url('/assets/images/takayamatei-800x534.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="430" height="430" />
                <p></p>
            </div>
            <ul>
                <li>
                    <a class="btn_map search-district" v-on:click="handleHeaderContentClick('district', $event)">
                        <img
                            src="/assets/images/svg/i_map.svg"
                            alt=""
                            class="img-fluid d-none d-lg-inline-block"
                            width="18"
                            height="18"
                        />
                        <img
                            src="/assets/images/svg/i_map_black.svg"
                            alt=""
                            class="img-fluid d-inline-block d-lg-none"
                            width="18"
                            height="18"
                        />
                        <span>エリアから探す</span></a
                    >
                </li>
                <li>
                    <a class="btn_stations search-station" v-on:click="handleHeaderContentClick('station', $event)">
                        <img
                            src="/assets/images/svg/i_stations.svg"
                            alt=""
                            class="img-fluid d-none d-lg-inline-block"
                            width="13"
                            height="13"
                        />
                        <img
                            src="/assets/images/svg/i_stations_black.svg"
                            alt=""
                            class="img-fluid d-inline-block d-lg-none"
                            width="13"
                            height="13"
                        />
                        <span>沿線から探す</span></a
                    >
                </li>
            </ul>
        </section>
        <section class="section_near_property">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2 class="title"><b>新着物件</b></h2>
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
        EstatesNearComponent: () => import('../components/EstatesNearComponent'),
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
