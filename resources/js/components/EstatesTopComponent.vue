<template>
    <ul class="list_property" v-if="estates.length">
        <li v-for="(estate, index) in estates">
            <div class="box_property_item" v-if="estate">
                <div class="box_property_item_img">
                    <a v-bind:href="'/detail/' + estate._id">
                        <img
                            v-lazy="estate.photo_first ? estate.photo_first : '/images/no-image.png'"
                            alt=""
                            class="img-fluid"
                        />
                    </a>
                </div>
                <div class="box_property_item_body">
                    <h2>
                        <a v-bind:href="'/detail/' + estate._id">{{
                            estate.custom_field ? estate.custom_field.content : ''
                        }}</a>
                        <template v-if="accessToken">
                            <a @click="addToWishList(estate._id, estate.is_wish)">
                                <WishlistComponent :data-wished="estate.is_wish"></WishlistComponent>
                            </a>
                        </template>
                    </h2>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p>
                                {{ estate.room_count }}{{ estate.service_rooms != '0' ? 'S' : ''
                                }}{{ estate.room_kind }} / {{ estate.tatemono_menseki }}㎡
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <ul class="list_property" v-else>
        <img v-lazy="'images/loading.gif'" alt="" class="img-fluid img-fluid-loading" />
    </ul>
</template>

<script>
import WishlistComponent from '../components/WishlistComponent';

export default {
    data() {
        return {
            estates: [],
            accessToken: false,
            existedEstate: false
        };
    },
    components: {
        WishlistComponent
    },
    mounted() {
        this.getListEstates();
    },
    methods: {
        getListEstates() {
            let accessToken = this.$getCookie('accessToken');
            let data = {
                limit: 10,
                page: 1
            };
            if (accessToken.length > 0) {
                data.email = this.$getCookie('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getCookie('userSocialId') == 'null') {
                    data.email = this.$getCookie('userEmail');
                    data.isSocial = false;
                }
                this.$store.dispatch('getEstateList', data).then(res => {
                    this.estates = res;
                });
            } else {
                this.$store.dispatch('getEstateList', data).then(res => {
                    this.estates = res;
                });
            }
        },

        // Add states to wishlist
        addToWishList(estateId, isWish) {
            let accessToken = this.$getCookie('accessToken');
            if (accessToken != '') {
                let data = {
                    estateId: estateId,
                    is_wish: 1,
                    accessToken: accessToken,
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
