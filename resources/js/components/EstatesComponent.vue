<template>
    <div>
        <div class="box_top">
            <div class="container">
                <h2 class="title mb-2">{{ titleSearch }}</h2>
                <!-- <p class="subtitle mb-4">リノベーション・中古マンション物件一覧</p> -->
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <ul v-if="estates.length" class="list_property" v-on:scroll="handleScroll">
                        <li
                            v-for="(estate, index) in estates"
                            :key="index._id"
                            v-bind:class="{ 'estate-last': index === estates.length - 1 }"
                        >
                            <div class="property_img">
                                <a v-bind:href="'/detail/' + estate._id"
                                    >
                                    <img
                                        v-lazy="
                                            estate.estate_information.estate_main_photo.length > 0
                                                ? estate.estate_information.estate_main_photo[0].url_path
                                                : '/images/no-image.png'
                                        "
                                        alt=""
                                        class="img-fluid"/>
                                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">カスタム<br />可能物件</p>
                                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                                    <div class="w_property_head">
                                        <p class="total_price">
                                            {{ estate.price }}<span>万円</span><span class="sub" v-if="estate.renovation_type != 'リノベ済物件'">（物件＋リノベーション）</span>
                                        </p>
                                        <div class="property_head">
                                        <div class="row">
                                            <div class="col-10 col-lg-10">
                                                <p class="property_name">{{ estate.estate_information.article_title }}</p>
                                                <p class="property_address">
                                                    {{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}
                                                </p>
                                                <p class="property_square">{{ estate.tatemono_menseki }}m²</p>
                                            </div>
                                            <div class="col-2 col-lg-2">
                                                <template v-if="accessToken">
                                                    <a @click="addToWishList(estate._id, estate.is_wish)">
                                                        <WishlistComponent :estate-id="estate._id" :data-wished="estate.is_wish"></WishlistComponent>
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
                    <div class="loading" v-if="hasMore" style="text-align: center;">
                        <img v-lazy="`/images/loading.gif`" width="300" />
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import estateModule from '../store/modules/estate.js';
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
            estates: [],
            page: 2,
            offsetTop: 0,
            heigthOfList: 0,
            hasMore: true,
            accessToken: false,
            lastEstate: [],
            titleSearch: '全ての物件一覧',
            hasMore: true
        };
    },
    components: {
        WishlistComponent: () => import('../components/WishlistComponent')
    },
    beforeMount() {
        this.getListEstates();
    },
    created() {
        this.$store.registerModule('estate', estateModule);
        window.addEventListener('scroll', this.handleScroll);
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
            let accessToken = this.$getLocalStorage('accessToken');
            let district = '';
            let station = '';
            let districtCode = '';
            let companyCode = '';
            if (typeof this.$route.params.searchCode !== 'undefined' && this.$route.params.searchCode.length > 0) {
                if (this.$route.params.searchCode.length >= 11) {
                    districtCode = this.$route.params.searchCode;
                } else {
                    companyCode = this.$route.params.searchCode;
                }
            }

            let data = {
                limit: 4,
                page: pageLoad,
                districtCode: districtCode,
                companyCode: companyCode,
            };
            if (district.length != 0) {
                data.address = district;
            }
            if (station.length != 0) {
                data.station = station;
            }
            
            if (accessToken) {
                data.email = this.$getLocalStorage('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getLocalStorage('userSocialId') == 'null') {
                    data.email = this.$getLocalStorage('userEmail');
                    data.isSocial = false;
                }

                this.$store.dispatch('getEstateList', data).then(res => {
                    this.estates = this.estates.concat(res[0]['data']);
                    this.lastEstate = res[0]['lastedEstate'];
                    if (this.estates.length < res[0].total) {
                        this.hasMore = true;
                    } else {
                        this.hasMore = false;
                    }
                });
            } else {
                this.$store.dispatch('getEstateList', data).then(res => {
                    this.estates = this.estates.concat(res[0]['data']);
                    this.lastEstate = res[0]['lastedEstate'];
                    if (this.estates.length < res[0].total) {
                        this.hasMore = true;
                    } else {
                        this.hasMore = false;
                    }
                });
            }
            if (window.localStorage.getItem('district') && districtCode != '') {
                
                this.titleSearch = this.$getLocalStorage('district') + 'の物件';
                window.localStorage.setItem('searchCode', this.titleSearch);
            }

            if (window.localStorage.getItem('station') && companyCode != '') {
                this.titleSearch = this.$getLocalStorage('station') + 'の物件';
                window.localStorage.setItem('searchCode', this.titleSearch);
            }
            // this.loading = false;
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
            let space = (this.page - 2);
            // console.log('Sroll at %d - Offset Top at %d - Space: %d', document.documentElement.scrollTop, this.offsetTop, space);
            // let bottomOfWindow = document.scrollingElement.scrollTop + $(window).height() === $(document).height();
            // if (bottomOfWindow) {
            //     this.getListEstates(this.page);
            //     this.setOffsetTop();
            //     this.page++;
            // }
            // console.log(document.documentElement.scrollTop);
            // console.log(document.scrollingElement.scrollTop);
            // if (document.documentElement.scrollTop - space > this.offsetTop && this.hasMore) {
            //     this.getListEstates(this.page);
            //     this.setOffsetTop();
            //     this.page++;
            // }
            // console.log(document.documentElement.scrollTop);
            // console.log(document.scrollingElement.scrollTop);
            // if (document.documentElement.scrollTop - space > this.offsetTop && this.hasMore) {
            //     this.getListEstates(this.page);
            //     this.setOffsetTop();
            //     this.page++;
            // }
            // console.log(this.loading)
            // if (this.loading == false) return

            if (document.scrollingElement.scrollTop > this.offsetTop && this.hasMore) {
                this.getListEstates(this.page);
                this.setOffsetTop();
                this.page++;
            }
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
                this.$store.dispatch('addWishList', data, accessToken);
            }
        }
    }
};
</script>
