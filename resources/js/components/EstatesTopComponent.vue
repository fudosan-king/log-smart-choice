<template>
    <ul class="list_property" v-if="estates">
        <li v-for="(estate, index) in estates" :key="index._id">
            <div class="property_img">
                <a v-bind:href="'/detail/' + estate._id">
                    <img
                        v-lazy="
                            estate.estate_information.estate_main_photo.length != 0
                                ? estate.estate_information.estate_main_photo[0].url_path
                                : '/images/no-image.png'
                        "
                        alt=""
                        class="img-fluid"
                        width="100%"
                        height="auto"
                    />
                
                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">カスタム<br />可能物件</p>
                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                    <div class="w_property_head">
                        <p class="total_price">
                            {{ estate.price }}<span>万円</span><span class="sub" v-if="estate.renovation_type != 'リノベ済物件'">（改装前価格）</span>
                        </p>
                        <div class="property_head">
                            <div class="row">
                                <div class="col-10 col-lg-10 align-self-center">
                                    <p class="property_name"><b>{{ estate.estate_information.article_title }}</b></p>
                                    <p class="property_address">
                                        <span>
                                        {{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}
                                        {{ estate.tatemono_menseki }}m² / {{ estate.room_count }}{{ estate.room_kind }}
                                        </span>
                                    </p>
                                    <!-- <p class="property_square">{{ estate.tatemono_menseki }}m² / {{ estate.room_count }}{{ estate.room_kind }}</p> -->
                                </div>
                                <div class="col-2 col-lg-2">
                                    <template v-if="accessToken">
                                        <a v-if="estate._id">
                                            <WishlistComponent
                                                :estate-id="estate._id"
                                                :data-wished="estate.is_wish"
                                            ></WishlistComponent>
                                        </a>
                                    </template>
                                    <template v-else>
                                        <a href="/login" class="btn_wishlist"></a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </li>
    </ul>
    <ul class="list_property" v-else-if="!isHidden">
        <img v-lazy="`images/loading1.gif`" alt="" class="img-fluid img-fluid-loading" height="auto" width="100%" />
    </ul>
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
            estates: [],
            accessToken: false,
            existedEstate: false,
            isHidden: false
        };
    },
    components: {
        WishlistComponent: () => import('../components/WishlistComponent')
    },
    mounted() {
        this.getListEstates();
    },
    methods: {
        getListEstates() {
            let accessToken = this.$getLocalStorage('accessToken');
            let data = {
                limit: 20,
                page: 1
            };
            if (accessToken) {
                data.email = this.$getLocalStorage('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getLocalStorage('userSocialId') == 'null') {
                    data.email = this.$getLocalStorage('userEmail');
                    data.isSocial = false;
                }
                this.$store.dispatch('getEstateList', data).then(res => {
                    if (res['data'].length >= 1) {
                        this.estates = res['data'];
                    } else {
                        this.estates = res['data'][0];
                    }
                });
            } else {
                this.$store.dispatch('getEstateList', data).then(res => {
                    if (res['data'].length >= 1) {
                        this.estates = res['data'];
                    } else {
                        this.estates = res['data'][0];
                    }
                });
            }
        }
    }
};
</script>
