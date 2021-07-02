<template>
    <ul class="list_property" v-if="estates.length">
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
                    />
                </a>
                <p class="total_price">
                    {{ estate.total_price }}<span>万円</span><span class="sub">（物件＋リノベーション）</span>
                </p>
                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">カスタム<br />可能物件</p>
                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                </div>
                <div class="property_head">
                    <div class="row">
                        <div class="col-10 col-lg-10">
                            <p class="property_name">{{ estate.estate_name }}</p>
                            <p class="property_address">
                                {{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}
                            </p>
                            <p class="property_square">{{ estate.tatemono_menseki }}m²</p>
                        </div>
                        <div class="col-2 col-lg-2">
                            <template v-if="accessToken">
                                <a @click="addToWishList(estate._id, estate.is_wish)">
                                    <WishlistComponent :data-wished="estate.is_wish"></WishlistComponent>
                                </a>
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
    loading: 'images/loading.gif',
    attempt: 1
});
export default {
    props: {
        estateId: String
    },
    data() {
        return {
            estates: [],
            accessToken: false,
            existedEstate: false,
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
            let accessToken = this.$getCookie('accessToken');
            let data = {};
            data.estate_id = this.estateId;
            if (accessToken.length > 0) {
                data.email = this.$getCookie('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getCookie('userSocialId') == 'null') {
                    data.email = this.$getCookie('userEmail');
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
            let accessToken = this.$getCookie('accessToken');
            if (accessToken != '') {
                let data = {
                    estateId: estateId,
                    is_wish: 1,
                    accessToken: accessToken
                };
                if (isWish === 1) {
                    data.is_wish = 0;
                }
                this.$store.dispatch('addWishList', data, accessToken);
            }
        }
    }
};
</script>
