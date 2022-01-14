<template>
    <ul class="archive-list" v-if="estates">
        <li v-for="(estate, index) in estates" :key="index._id">
            <div class="property-archive_item">
                <a v-bind:href="'/detail/' + estate._id">
                    <div class="property_img">
                        <template v-if="estate.estate_information">
                            <img
                                v-lazy="
                                    estate.estate_information.estate_main_photo.length != 0
                                        ? estate.estate_information.estate_main_photo[0].url_path
                                        : '/images/no-image.png'
                                "
                                alt=""
                                class="img-fluid"
                                width="265"
                            />
                        </template>
                        <div class="group_price" v-if="estate.renovation_type != 'カスタム可能物件'">
                            <div class="g-bg">
                                <div class="g-bg_item bg-black"></div>
                                <p class="total_price">
                                    {{ estate.price }}<span class="unit">万円</span><span class="sub">リノベ済</span>
                                </p>
                            </div>
                            <template v-if="estate.estate_information">
                                <div class="g-bg" v-if="estate.estate_information.estate_fee == 1">
                                    <div class="g-bg_item bg-gray"></div>
                                    <p class="price_info">仲介手数料無料</p>
                                </div>
                            </template>
                        </div>
                        <div class="group_price" v-else>
                            <div class="g-bg">
                                <div class="g-bg_item bg-black"></div>
                                <p class="total_price">
                                    {{ estate.price }}<span class="unit">万円</span
                                    ><span class="sub">（改装前価格）</span>
                                </p>
                            </div>
                            <template v-if="estate.estate_information">
                                <div class="g-bg" v-if="estate.estate_information.estate_fee == 1">
                                    <div class="g-bg_item bg-gray"></div>
                                    <p class="price_info">仲介手数料無料</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </a>
                <div class="w_property-archive_head">
                    <a v-bind:href="'/detail/' + estate._id"> </a>
                    <div class="property-archive_head">
                        <a v-bind:href="'/detail/' + estate._id">
                            <div class="property_info">
                                <template v-if="estate.estate_information">
                                    <p class="property_name">
                                        {{ estate.estate_information.article_title }}
                                    </p>
                                </template>
                                <p class="property_address">
                                    <span>
                                        {{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}
                                        {{ estate.tatemono_menseki }}m² / {{ estate.room_count }}{{ estate.room_kind }}
                                    </span>
                                </p>
                            </div>
                        </a>
                        <div class="property_wishlist">
                            <template v-if="accessToken">
                                <a v-if="estate._id">
                                    <WishlistComponent
                                        :estate-id="estate._id"
                                        :data-wished="estate.is_wish"
                                    ></WishlistComponent>
                                </a>
                            </template>
                            <template v-else>
                                <a :href="'/login?redirect=' + urlRedirect" class="btn_wishlist"></a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </li>
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
    props: {
        estateId: String
    },
    data() {
        let urlRedirect = this.$route.fullPath;
        return {
            estates: [],
            accessToken: false,
            existedEstate: false,
            urlRedirect: urlRedirect
        };
    },
    components: {
        WishlistComponent: () => import('../components/WishlistComponent')
    },
    mounted() {
        this.getNearEstates();
    },
    methods: {
        getNearEstates() {
            let accessToken = this.$getLocalStorage('accessToken');
            let data = {};
            data.estate_id = this.estateId;
            if (accessToken) {
                data.email = this.$getLocalStorage('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getLocalStorage('userSocialId') == 'null') {
                    data.email = this.$getLocalStorage('userEmail');
                    data.isSocial = false;
                }
            }
            this.$store.dispatch('getEstatesNear', data).then(res => {
                this.estates = res;
                this.isHidden = true;
            });
        },

        // Add states to wishlist
        addToWishList(estateId, isWish) {
            let accessToken = this.$getLocalStorage('accessToken');
            if (accessToken != '') {
                let data = {
                    estateId: estateId,
                    is_wish: 1,
                    accessToken: accessToken
                };
                if (isWish === 1) {
                    data.is_wish = 0;
                }
                this.$store.dispatch('addWishList', data, accessToken).catch(err => {
                    this.$setCookie('accessToken3d', '', 1);
                    this.$removeAuthLocalStorage();
                    this.$removeLocalStorage('announcement_count');
                    this.$router.push({ name: 'login' }).catch(() => {});
                });
            }
        }
    }
};
</script>
