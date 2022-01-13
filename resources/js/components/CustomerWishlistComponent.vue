<template>
    <div class="property-listing">
        <div class="listing_top">
            <div class="container">
                検索結果 <b class="total_estates_wishlist">{{ total }}</b> 件
            </div>
        </div>
        <div class="listing">
            <div class="container">
                <ul v-if="wishtlist.length" class="archive-list" v-on:scroll="handleScroll">
                    <li v-for="(wishtlistItem, index) in wishtlist" :key="index._id">
                        <div class="property-archive_item">
                            <a v-bind:href="'/detail/' + wishtlistItem._id">
                                <div class="property_img">
                                    <template v-if="wishtlistItem.estate_information">
                                        <img
                                            v-lazy="
                                                wishtlistItem.estate_information.estate_main_photo.length
                                                    ? wishtlistItem.estate_information.estate_main_photo[0].url_path
                                                    : '/images/no-image.png'
                                            "
                                            alt=""
                                            class="img-fluid"
                                            height="auto"
                                            width="100%"
                                        />
                                    </template>
                                    <div class="group_price" v-if="wishtlistItem.renovation_type != 'カスタム可能物件'">
                                        <div class="g-bg">
                                            <div class="g-bg_item bg-yellow"></div>
                                            <p class="total_price">
                                                {{ wishtlistItem.price }}<span class="unit">万円</span>
                                                <span class="sub">リノベ済</span>
                                            </p>
                                        </div>
                                        <template v-if="wishtlistItem.estate_information">
                                            <div class="g-bg" v-if="wishtlistItem.estate_information.estate_fee == 1">
                                                <div class="g-bg_item bg-gray"></div>
                                                <p class="price_info">仲介手数料無料</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="group_price" v-else>
                                        <div class="g-bg">
                                            <div class="g-bg_item bg-black"></div>
                                            <p class="total_price">
                                                {{ wishtlistItem.price }}<span class="unit">万円</span
                                                ><span class="sub">（改装前価格）</span>
                                            </p>
                                        </div>
                                        <template v-if="wishtlistItem.estate_information">
                                            <div class="g-bg" v-if="wishtlistItem.estate_information.estate_fee == 1">
                                                <div class="g-bg_item bg-gray"></div>
                                                <p class="price_info">仲介手数料無料</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </a>
                            <div class="w_property-archive_head">
                                <a v-bind:href="'/detail/' + wishtlistItem._id"> </a>
                                <div class="property-archive_head">
                                    <a v-bind:href="'/detail/' + wishtlistItem._id">
                                        <div class="property_info">
                                            <template v-if="wishtlistItem.estate_information">
                                                <p class="property_name">
                                                    {{ wishtlistItem.estate_information.article_title }}
                                                </p>
                                            </template>
                                            <p class="property_address">
                                                <span>
                                                    {{ wishtlistItem.address.city }}{{ wishtlistItem.address.ooaza
                                                    }}{{ wishtlistItem.address.tyoume }}
                                                    {{ wishtlistItem.tatemono_menseki }}m²/ {{ wishtlistItem.room_count
                                                    }}{{ wishtlistItem.room_kind }}
                                                </span>
                                            </p>
                                        </div>
                                    </a>
                                    <div class="property_wishlist">
                                        <template v-if="accessToken">
                                            <a v-if="wishtlistItem._id" v-on:click="removeWishList">
                                                <WishlistComponent
                                                    :estate-id="wishtlistItem._id"
                                                    :data-wished="wishtlistItem.is_wish"
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
                <PaginationComponent
                    :pagination-info="paginationInfo"
                    :page-choice="pageChoice"
                    @getListEstates="getWishlist"
                ></PaginationComponent>
                <!-- <div class="loading" v-if="hasMore" style="text-align: center;">
                    <img v-lazy="`/images/loading1.gif`" height="auto" width="100%" />
                </div> -->
            </div>
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
    loading: 'images/loading1.gif',
    attempt: 1
});
export default {
    data() {
        let urlRedirect = this.$route.fullPath;
        let pageChoice = this.$getLocalStorage('pageChoice') ? this.$getLocalStorage('pageChoice') : 1;
        return {
            wishtlist: [],
            page: 2,
            offsetTop: 0,
            heigthOfList: 0,
            isHidden: false,
            accessToken: false,
            hasMore: true,
            total: 0,
            urlRedirect: urlRedirect,
            paginationInfo: [],
            pages: 0,
            pageChoice: pageChoice
        };
    },
    components: {
        WishlistComponent: () => import('../components/WishlistComponent'),
        PaginationComponent: () => import('../components/PaginationComponent')
    },
    beforeMount() {
        this.getWishlist();
    },
    created() {
        this.$store.registerModule('wishtlist', wishlistModule);
        // window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy() {
        this.$store.unregisterModule('wishlist');
    },
    destroyed() {
        // window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        // Gui yeu cau den server sau moi lan cuon xuong
        getWishlist(pageLoad) {
            let accessToken = this.$getLocalStorage('accessToken');
            let data = {
                limit: 16,
                page: pageLoad
            };
            if (accessToken) {
                data.email = this.$getLocalStorage('userSocialId');
                data.isSocial = true;
                data.accessToken = accessToken;
                this.accessToken = true;
                if (this.$getLocalStorage('userSocialId') == 'null') {
                    data.email = this.$getLocalStorage('userEmail');
                    data.isSocial = false;
                }
                this.$store.dispatch('getWishlist', data).then(res => {
                    // this.wishtlist = this.wishtlist.concat(res[0]['data']['data']);
                    this.wishtlist = res[0]['data']['data'];
                    this.paginationInfo = res[0]['paginationInfo'];
                    console.log(this.paginationInfo);
                    this.total = res[0]['data']['total'];
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
