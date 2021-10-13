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
                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">カスタム<br />可能物件</p>
                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                    <div class="w_property_head">
                        <p class="total_price">
                            {{ estate.price }}<span>万円</span
                            ><span class="sub" v-if="estate.renovation_type != 'リノベ済物件'"
                                >（物件＋リノベーション）</span
                            >
                        </p>
                        <div class="property_head">
                            <div class="row">
                                <div class="col-10 col-lg-10">
                                    <p class="property_name">{{ estate.estate_information.article_title }}</p>
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
                                        <a @click="addToWishList(estate._id, estate.is_wish)">
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
                existedEstate: false
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
