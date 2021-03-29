<template>
    <ul class="list_property">
        <li v-for="(estate, index) in estates">
            <div class="box_property_item">
                <div class="box_property_item_img">
                    <a v-bind:href="'/detail/' + estate._id">
                        <img v-bind:src="estate['photo_first'] ? estate.photo_first : '/images/no-image.png'" alt=""
                             class="img-fluid">
                    </a>
                </div>
                <div class="box_property_item_body">
                    <h2>
                        <a v-bind:href="'/detail/' + estate._id">{{
                                estate.custom_field ? estate.custom_field.content : ""
                            }}</a>
                        <template v-if="customer.is_logged">
                            <a @click="addToWishList(estate._id, estate.is_wish)">
                                <WishlistComponent :data-wished="estate.is_wish"></WishlistComponent>
                            </a>
                        </template>
                    </h2>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p>{{ estate.room_count }}{{ estate.service_rooms != '0' ? 'S' : '' }}{{ estate.room_kind }} / {{estate.tatemono_menseki }}㎡</p>
                        </div>
                        <!-- <div class="col-12 col-lg-6">
                            <p class="property_info">
                                <span>30代ご夫婦</span>
                                <span>お子様2人</span>
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
import WishlistComponent from '../components/WishlistComponent'

export default {
    data() {
        return {
            estates: [],
            customer: {},
        }
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
            let auth = {
                    username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                    password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
                };
                if (accessToken.length > 0) {
                    axios({
                        url: '/customer',
                        method: 'POST',
                        data: {},
                        headers: {
                            'content-type': 'application/json',
                            'AuthorizationBearer': `Bearer ${accessToken}`,
                        },
                        auth: auth,
                    })
                    .then(resp => {
                        let emailCustomer = resp.data.customer.email;
                        this.customer = resp.data.customer;
                        axios({url: '/list', method: 'POST', data: {'limit': 10, 'page': 1, 'email': emailCustomer}})
                            .then(resp => {
                                this.estates = this.estates.concat(resp.data['data']);
                            })
                            .catch(err => {
                                    console.log('Can not get list estates');
                                }
                            );
                        })
                        .catch(err => {});
                } else {
                    axios({url: '/list', method: 'POST', data: {'limit': 10, 'page': 1}, auth: auth,})
                        .then(resp => {
                            this.estates = this.estates.concat(resp.data['data']);
                            if (resp.data['data'].length) {
                            }
                        })
                        .catch(err => {
                            console.log('Can not get list estates');
                        }
                    );
            }
        },
        // Add states to wishlist
        addToWishList(estateId, isWish) {
            let accessToken = this.$getCookie('accessToken');
            let auth = {
                username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
            };
            if (accessToken.length > 0) {
                let data = {
                    estateId: estateId,
                    is_wish: 1,
                };
                if (isWish === 1) {
                    data = {
                        estateId: estateId,
                        is_wish: 0,
                    }
                }
                axios.post("/wishlist", data, {
                    headers: {
                        'content-type': 'application/json',
                        'AuthorizationBearer': `Bearer ${accessToken}`,
                    },
                    auth: auth,
                }).then((res) => {
                }, (error) => {
                });
            }
        },
    },

};
</script>
