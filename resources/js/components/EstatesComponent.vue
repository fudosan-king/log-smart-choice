<template>
    <section class="section_near_property custom pt-0 bg-white">
        <div class="box_top">
            <div class="container">
                <h2 class="title mb-2 text-center">検索結果</h2>
                <div class="info_topsearch">
                    <template v-if="conditionSearch">
                        <p class="searchby_area_label"><b> {{ conditionSearch.flag_search == 'district' ? 'エリアから探す：' : '沿線・駅から探す：' }}</b>{{ conditionSearch.key_word }}</p>
                        <template v-if="conditionSearch.price">
                            <p class="mb-1"><b>価格：</b>{{ conditionSearch.price.min }}～{{ conditionSearch.price.max }}</p>
                        </template>
                        <template v-if="conditionSearch.square">
                            <p><b>広さ：</b>{{ conditionSearch.square.min }}～{{ conditionSearch.square.max }}</p>
                        </template>
                        <template v-if="conditionSearch.tab_search_name">
                            <p><b>こだわり：</b>{{ conditionSearch.tab_search_name}}</p>
                        </template>
                    </template>
                </div>
                <ul class="box_sort">
                    <li><a class="border-0 pl-0 search_number" href="#">検索結果 <span><b>{{ total }}</b></span> 件</a></li>
                    <li><a href="/search"><img src="/assets/images/svg/i_sort.svg" alt="" class="img-fluid" width="15"><span> 条件を変更する</span></a></li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <ul v-if="estates" class="list_property" v-on:scroll="handleScroll">
                        <li
                            v-for="(estate, index) in estates"
                            :key="index._id"
                            v-bind:class="{ 'estate-last': index === estates.length - 1 }"
                        >
                            <div class="property_img">
                                <a v-bind:href="'/detail/' + estate._id">
                                <template v-if="estate.estate_information">
                                    <img
                                        v-lazy="
                                            estate.estate_information.estate_main_photo.length > 0
                                                ? estate.estate_information.estate_main_photo[0].url_path
                                                : '/images/no-image.png'
                                        "
                                        alt=""
                                        class="img-fluid"
                                        height="auto"
                                        width="100%"
                                    />
                                </template>
                                    <p class="label_custom" v-if="estate.renovation_type == 'カスタム可能物件'">
                                        カスタム<br />可能物件
                                    </p>
                                    <p class="label_custom renovated" v-else>リノベ済<br />物件</p>
                                    <div class="w_property_head">
                                        <p class="total_price">
                                            {{ estate.price }}<span>万円</span
                                            ><span class="sub" v-if="estate.renovation_type != 'リノベ済物件'"
                                                >（改装前価格）</span
                                            >
                                        </p>
                                        <div class="property_head">
                                            <div class="row">
                                                <div class="col-10 col-lg-10 align-self-center">
                                                    <template v-if="estate.estate_information">
                                                        <p class="property_name">
                                                            <b>{{ estate.estate_information.article_title }}</b>
                                                        </p>
                                                    </template>
                                                    <p class="property_address">
                                                        <span>
                                                            {{ estate.address.city }}{{ estate.address.ooaza
                                                        }}{{ estate.address.tyoume }}{{ estate.tatemono_menseki }}m² / {{ estate.room_count }}{{ estate.room_kind }}
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
                    <div class="loading" v-if="hasMore" style="text-align: center;">
                        <img v-lazy="`/images/loading1.gif`" width="300" height="300" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import estateModule from '../store/modules/estate.js';
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
            let conditionSearch = this.$getLocalStorage('conditionSearch') ? JSON.parse(this.$getLocalStorage('conditionSearch')) : [];
            let tabListActived = conditionSearch.tabSesarch ? conditionSearch.tabSesarch : [];
            
            return {
                estates: [],
                page: 2,
                offsetTop: 0,
                heigthOfList: 0,
                hasMore: true,
                accessToken: false,
                conditionSearch: {},
                total: 0,
                tabListActived: tabListActived
            };
        },
        components: {
            WishlistComponent: () => import('../components/WishlistComponent')
        },
        mounted() {
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
                let flagSearch = this.$getLocalStorage('tabActive') ? this.$getLocalStorage('tabActive') : 'area';
                let conditionSearch = this.$getLocalStorage('conditionSearch') ? JSON.parse(this.$getLocalStorage('conditionSearch')) : [];

                let keyWord = this.$route.query.keyWord;
                let minPrice = this.$route.query.minPrice;
                let maxPrice = this.$route.query.maxPrice;
                let minSquare = this.$route.query.minSquare;
                let maxSquare = this.$route.query.maxSquare;
                let tabSearch = this.$route.query.tabSearch ? this.$route.query.tabSearch : this.tabListActived;
                let tabSearchName = this.$route.query.tabSearchName;

                let data = {
                    limit: 4,
                    page: pageLoad,
                    flag_search: flagSearch,
                };

                if (conditionSearch.districts) {
                    data.districts = Array.isArray(conditionSearch.districts) ? conditionSearch.districts : [conditionSearch.districts];
                }

                if (conditionSearch.stations) {
                    data.stations = conditionSearch.stations;
                }

                if (minPrice) {
                    data.min_price = minPrice;
                }
                if (maxPrice) {
                    data.max_price = maxPrice;
                }
                if (minSquare) {
                    data.min_square = minSquare;
                }
                if (maxSquare) {
                    data.max_square = maxSquare;
                }
                if (tabSearch) {
                    data.tab_search = Array.isArray(tabSearch) ? tabSearch : [tabSearch];
                }

                if (tabSearchName) {
                    data.tab_search_name = tabSearchName;
                }

                if (accessToken) {
                    data.email = this.$getLocalStorage('userSocialId');
                    data.isSocial = true;
                    this.accessToken = true;
                    if (this.$getLocalStorage('userSocialId') == 'null') {
                        data.email = this.$getLocalStorage('userEmail');
                        data.isSocial = false;
                    }

                    this.$store
                        .dispatch('getEstateList', data)
                        .then(res => {
                            this.estates = this.estates.concat(res[0]['data']);
                            this.conditionSearch = res[0]['conditionSearch'];
                            this.total = res[0]['total'];
                            // this.lastEstate = res[0]['lastedEstate'];
                            if (this.estates.length < res[0].total) {
                                this.hasMore = true;
                            } else {
                                this.hasMore = false;
                            }
                        })
                        .catch(err => {
                            this.$setCookie('accessToken3d', '', 1);
                            this.$removeAuthLocalStorage();
                            this.$removeLocalStorage('announcement_count');
                        });
                } else {
                    this.$store
                        .dispatch('getEstateList', data)
                        .then(res => {
                            this.estates = this.estates.concat(res[0]['data']);
                            this.conditionSearch = res[0]['conditionSearch'];
                            this.total = res[0]['total'];
                            // this.lastEstate = res[0]['lastedEstate'];
                            if (this.estates.length < res[0].total) {
                                this.hasMore = true;
                            } else {
                                this.hasMore = false;
                            }
                        })
                        .catch(err => {
                            this.$setCookie('accessToken3d', '', 1);
                            this.$removeAuthLocalStorage();
                            this.$removeLocalStorage('announcement_count');
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
                let space = this.page - 2;
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
                    this.$store
                        .dispatch('addWishList', data, accessToken)
                        .then()
                        .catch(err => {
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
