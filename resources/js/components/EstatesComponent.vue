<template>
    <div class="col-12 col-lg-12">
        <ul v-if="estates.length" class="list_property" v-on:scroll="handleScroll">
            <li
                v-for="(estate, index) in estates"
                :key="index._id"
                v-bind:class="{ 'estate-last': index === estates.length - 1 }"
            >
                <div class="box_property_item">
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
                            <template v-if="customer.is_logged">
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
        <div class="loading" v-if="!isHidden" style="text-align: center;">
            <img src="/images/loading.gif" />
        </div>
    </div>
</template>

<script>
import WishlistComponent from '../components/WishlistComponent';
import estateModule from '../store/modules/estate.js';

export default {
    data() {
        return {
            estates: [],
            page: 2,
            offsetTop: 0,
            heigthOfList: 0,
            isHidden: false,
            customer: {}
        };
    },
    components: {
        WishlistComponent
    },
    beforeMount() {
        this.getListEstates();
    },
    created() {
        window.addEventListener('scroll', this.handleScroll);
        this.$store.registerModule('estate', estateModule);
    },
    beforeDestroy() {
        this.$store.unregisterModule('estate');
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        // Gui yeu cau den server sau moi lan cuon xuong
        getListEstates(pageLoad) {
            let accessToken = this.$getCookie('accessToken');
            let data = {
                limit: 4,
                page: pageLoad
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
                    this.estates = this.estates.concat(res);
                });
            }
        },
        // Khi them danh sach phia duoi thi tinh toan lai do cao
        setOffsetTop() {
            this.offsetTop = this.offsetTop + this.heigthOfList;
        },
        // Tinh do cao cua danh sach sao cho cuon xuong duoi cung thi gui API
        setInitHeigthOfList() {
            let estate_last = this.$el.querySelector('.estate-last');
            if (estate_last) {
                this.heigthOfList = estate_last.offsetTop;
                this.offsetTop = estate_last.offsetTop;
            }
        },
        // Su kien cuon mouse.
        // Do cao cua 1 dong la space (423)
        handleScroll(event) {
            if (!this.heigthOfList) {
                this.setInitHeigthOfList();
            }
            let space = 423 * (this.page - 2);
            // console.log('Sroll at %d - Offset Top at %d - Space: %d', document.documentElement.scrollTop, this.offsetTop, space);
            if (document.documentElement.scrollTop - space > this.offsetTop) {
                this.isHidden = false;
                this.getListEstates(this.page);
                this.setOffsetTop();
                this.page++;
            }
        },

        // Add states to wishlist
        addToWishList(estateId, isWish) {
            this.$store.dispatch('addWishList', estateId, isWish);
        }
    }
};
</script>
