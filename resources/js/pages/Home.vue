<template>
    <main id="main">
        <section class="section_banner" style="background-image: url('images/KV.jpg');">
                <div class="caption d-none d-lg-block">
                    <img src="/assets/images/svg/label.svg" alt="" class="img-fluid" width="430">
                    <p>『自分に合った住まい』を考え、新しい暮らしの夢を膨らませませんか？<br>
                    自宅にいながら最適なリノベーションを全力でサポートいたします。</p>
                </div>
                <ul>
                    <li>
                        <a href="#">
                        <img src="/assets/images/svg/i_map.svg" alt="" class="img-fluid d-none d-lg-inline-block" width="18">
                        <img src="/assets/images/svg/i_map_black.svg" alt="" class="img-fluid d-inline-block d-lg-none" width="18"> 
                        エリアから探す</a>
                    </li>
                    <li><a href="#">
                        <img src="/assets/images/svg/i_stations.svg" alt="" class="img-fluid d-none d-lg-inline-block" width="13">
                        <img src="/assets/images/svg/i_stations_black.svg" alt="" class="img-fluid d-inline-block d-lg-none" width="13">
                         沿線から探す</a></li>
                    <li>
                        <a href="#">
                        <img src="/assets/images/svg/i_locations.svg" alt="" class="img-fluid d-none d-lg-inline-block" width="14">
                        <img src="/assets/images/svg/i_locations_black.svg" alt="" class="img-fluid d-inline-block d-lg-none" width="14">
                         MAPから探す</a>
                    </li>
                </ul>
            </section>

            <section class="section_new_property">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h2 class="title">新着物件</h2>
                            <estates-top-component></estates-top-component>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section_near_property bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h2 class="title">表参道エリアの物件</h2>
                            <estates-near-component></estates-near-component>
                            <p class="text-center mt-3"><a v-on:click="clearConditionSearch" class="btn btnSeemore">もっと見る</a></p>
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
    components: {
        EstatesTopComponent: () => import('../components/EstatesTopComponent'),
        EstatesNearComponent: () => import('../components/EstatesNearComponent'),
    },
    methods: {
        clearConditionSearch() {
            this.$setCookie('district', '', 1);
            this.$setCookie('station', '', 1);
            this.$router.push('list');
        }
    }
};
</script>
