<template>
    <div class="col-12 col-lg-12">
        <h2 class="title" v-if="lastEstate.address">{{ lastEstate.address.city }}</h2>
        <ul v-if="wishtlist.length" class="list_property" v-on:scroll="handleScroll">
            <li
                v-for="(wishtlistItem, index) in wishtlist"
                :key="index._id"
                v-bind:class="{ 'estate-last': index === wishtlistItem.length - 1 }"
            >
                <div class="property_img">
                    <a v-bind:href="'/detail/' + wishtlistItem._id"
                        ><img
                            v-lazy="
                                wishtlistItem.estate_information.estate_main_photo.length
                                    ? wishtlistItem.estate_information.estate_main_photo[0].url_path
                                    : '/images/no-image.png'
                            "
                            alt=""
                            class="img-fluid"
                    /></a>
                    <p class="total_price">
                        {{ wishtlistItem.price }}<span>万円</span
                        ><span class="sub" v-if="wishtlistItem.renovation_type != 'リノベ済物件'"
                            >（物件＋リノベーション）</span
                        >
                    </p>
                    <p class="label_custom" v-if="wishtlistItem.renovation_type == 'カスタム可能物件'">
                        カスタム<br />可能物件
                    </p>
                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                </div>
                <div class="property_head">
                    <div class="row">
                        <div class="col-10 col-lg-10">
                            <p class="property_name">{{ wishtlistItem.estate_information.article_title }}</p>
                            <p class="property_address" v-if="wishtlistItem.address">
                                <span>
                                {{ wishtlistItem.address.city }}{{ wishtlistItem.address.ooaza
                                }}{{ wishtlistItem.address.tyoume }}
                                {{ wishtlistItem.tatemono_menseki }}m²/ {{ wishtlistItem.room_count }}{{ wishtlistItem.room_kind }}
                                </span>
                            </p>
                            <p class="property_square"></p>
                        </div>
                        <div class="col-2 col-lg-2">
                            <template v-if="accessToken">
                                <a v-if="wishtlistItem._id" v-on:click="removeWishList">
                                    <WishlistComponent
                                        :estate-id="wishtlistItem._id"
                                        :data-wished="wishtlistItem.is_wish"
                                    ></WishlistComponent>
                                </a>
                            </template>
                            <template v-else>
                                <a href="/login" class="btn_wishlist"></a>
                            </template>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="loading" v-if="hasMore" style="text-align: center;">
            <img v-lazy="`/images/loading.gif`" />
        </div>
    </div>
</template>

<script>
    import wishlistModule from '../store/modules/wishlist.js';
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
                wishtlist: [],
                page: 2,
                offsetTop: 0,
                heigthOfList: 0,
                isHidden: false,
                accessToken: false,
                lastEstate: [],
                hasMore: true
            };
        },
        components: {
            WishlistComponent: () => import('../components/WishlistComponent')
        },
        beforeMount() {
            this.getWishlist();
        },
        created() {
            this.$store.registerModule('wishtlist', wishlistModule);
            window.addEventListener('scroll', this.handleScroll);
        },
        beforeDestroy() {
            this.$store.unregisterModule('wishlist');
        },
        destroyed() {
            window.removeEventListener('scroll', this.handleScroll);
        },
        methods: {
            // Gui yeu cau den server sau moi lan cuon xuong
            getWishlist(pageLoad) {
                let accessToken = this.$getLocalStorage('accessToken');
                let data = {
                    limit: 8,
                    page: pageLoad
                };
                if (accessToken) {
                    data.email = this.$getLocalStorage('userSocialId');
                    data.isSocial = true;
                    this.accessToken = true;
                    if (this.$getLocalStorage('userSocialId') == 'null') {
                        data.email = this.$getLocalStorage('userEmail');
                        data.isSocial = false;
                    }
                    this.$store.dispatch('getWishlist', data).then(res => {
                        this.wishtlist = this.wishtlist.concat(res[0]['data']['data']);
                        if (this.wishtlist.length < res[0]['data'].total) {
                            this.hasMore = true;
                        } else {
                            this.hasMore = false;
                        }
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
                if (document.scrollingElement.scrollTop - space > this.offsetTop) {
                    this.isHidden = false;
                    if (this.hasMore) {
                        this.getWishlist(this.page);
                        this.setOffsetTop();
                        this.page++;
                    }
                }
            },

            //Remove wishlist
            removeWishList() {
                this.$router.go(0);
            }
        }
    };
</script>
