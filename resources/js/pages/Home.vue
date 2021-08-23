<template>
    <main id="main">
        <section class="section_banner" style="background-image: url('/assets/images/takayamatei-800x534.jpg');">
            <div class="caption">
                <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="430" />
                <p>
                    住みたいエリア、広さ、予算、ライフスタイル…<br>
                    あなたの価値観にあった「中古＋リノベーション」を提案する<br>
                    SDGsな住まいソリューション<br>
                </p>
            </div>
            <ul>
                <li>
                    <a class="btn_map search-district" v-on:click="handleHeaderContentClick('district', $event)">
                        <img
                            src="/assets/images/svg/i_map.svg"
                            alt=""
                            class="img-fluid d-none d-lg-inline-block"
                            width="18"
                        />
                        <img
                            src="/assets/images/svg/i_map_black.svg"
                            alt=""
                            class="img-fluid d-inline-block d-lg-none"
                            width="18"
                        />
                        エリアから探す</a
                    >
                </li>
                <li>
                    <a class="btn_stations search-station" v-on:click="handleHeaderContentClick('station', $event)">
                        <img
                            src="/assets/images/svg/i_stations.svg"
                            alt=""
                            class="img-fluid d-none d-lg-inline-block"
                            width="13"
                        />
                        <img
                            src="/assets/images/svg/i_stations_black.svg"
                            alt=""
                            class="img-fluid d-inline-block d-lg-none"
                            width="13"
                        />
                        沿線から探す</a
                    >
                </li>
                <!-- <li>
                    <a v-on:click="handleHeaderContentClick('station', $event)">
                        <img
                            src="/assets/images/svg/i_locations.svg"
                            alt=""
                            class="img-fluid d-none d-lg-inline-block"
                            width="14"
                        />
                        <img
                            src="/assets/images/svg/i_locations_black.svg"
                            alt=""
                            class="img-fluid d-inline-block d-lg-none"
                            width="14"
                        />
                        MAPから探す</a
                    >
                </li> -->
            </ul>
        </section>
        <search-component 
            :search-type="searchType"
            v-if="searchType"
            @handleCloseClick="handleCloseSearch()">

        </search-component>
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
    loading: 'images/loading.gif',
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
        SearchComponent: () => import('../components/SearchComponent'),
    },
    methods: {
        clearConditionSearch() {
            this.$setCookie('district', '', 1);
            this.$setCookie('station', '', 1);
            this.$router.push('list');
        },
        handleHeaderContentClick (type = 'district', event) {
            event.preventDefault();
            if (this.searchType != type) {
                this.searchType = type;
            }
            // LSMEvent.$emit("handleSeachClick", type);

        },

        handleCloseSearch() {
            this.searchType = '';
        }
    }
};
</script>
