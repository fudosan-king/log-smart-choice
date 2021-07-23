<template>
    <div class="col-12 col-lg-12">
        <h2 class="title">{{ titleSearch }}</h2>
        <p class="subtitle mb-4">リノベーション・中古マンション物件一覧</p>
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
                            class="img-fluid"
                    />
                    </a>
                    <p class="total_price">
                        {{ estate.total_price }}<span>万円</span><span class="sub">（物件＋リノベーション）</span>
                    </p>
                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">
                        カスタム<br />可能物件
                    </p>
                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                </div>
                <div class="property_head">
                    <div class="row">
                        <div class="col-10 col-lg-10">
                            <p class="property_name">{{ estate.estate_name }}</p>
                            <p class="property_address" v-if="estate.address">
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
            titleSearch: '全物件',
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
            let accessToken = this.$getCookie('accessToken');
            // let district = this.$getCookie('district');
            let district = '';
            // let station = this.$getCookie('station');
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
            
            if (accessToken.length > 0) {
                data.email = this.$getCookie('userSocialId');
                data.isSocial = true;
                this.accessToken = true;
                if (this.$getCookie('userSocialId') == 'null') {
                    data.email = this.$getCookie('userEmail');
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
            if (this.$getCookie('district') && districtCode != '') {
                this.titleSearch = this.$getCookie('district');
            }

            if (this.$getCookie('station') && companyCode != '') {
                this.titleSearch = this.$getCookie('station');
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
            if (document.documentElement.scrollTop - space > this.offsetTop && this.hasMore) {
                this.getListEstates(this.page);
                this.setOffsetTop();
                this.page++;
            }
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
