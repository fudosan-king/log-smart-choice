<template>
    <section class="bg-white pb-0">
        <div class="property-listing">
            <div class="listing_top">
                <div class="container">
                    <h2>検索結果</h2>
                    <div class="listing_info">
                        <template v-if="conditionSearch">
                            <p class="searchby_area_label" v-if="conditionSearch.key_word != '指定なし'">
                                <b>
                                    {{
                                        conditionSearch.flag_search == 'area'
                                            ? 'エリアから探す：'
                                            : '沿線・駅から探す：'
                                    }}</b
                                >{{ conditionSearch.key_word }}
                            </p>
                            <template v-if="conditionSearch.price">
                                <p
                                    class="mb-1"
                                    v-if="
                                        conditionSearch.price.min != '下限なし' ||
                                        conditionSearch.price.max != '上限なし'
                                    "
                                >
                                    <b>価格：</b>{{ conditionSearch.price.min }}～{{ conditionSearch.price.max }}
                                </p>
                            </template>
                            <template v-if="conditionSearch.square">
                                <p
                                    v-if="
                                        conditionSearch.square.min != '下限なし' ||
                                        conditionSearch.square.max != '上限なし'
                                    "
                                >
                                    <b>広さ：</b>{{ conditionSearch.square.min }}～{{ conditionSearch.square.max }}
                                </p>
                            </template>
                            <template v-if="conditionSearch.tab_search_name">
                                <p><b>こだわり：</b>{{ conditionSearch.tab_search_name }}</p>
                            </template>
                        </template>
                    </div>
                    <div class="listing_sort">
                        <div class="border-0 pl-0 search_number">
                            検索結果
                            <span
                                ><b>{{ total }}</b></span
                            >
                            件
                        </div>
                        <ul>
                            <li>
                                <button type="button" class="btn btn-filter black" v-on:click="goSearchPage">
                                    <i class="c-icon i-filter-white"></i>
                                    条件を変更する
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="listing">
                <div class="container">
                    <ul class="archive-list" v-if="estates">
                        <li v-for="(estate, index) in estates" :key="index._id">
                            <div class="property-archive_item">
                                <a v-bind:href="'/detail/' + estate._id">
                                    <div class="property_img">
                                        <template v-if="estate.estate_information">
                                            <img
                                                v-lazy="
                                                    estate.estate_information.estate_main_photo.length != 0
                                                        ? estate.estate_information.estate_main_photo[0].url_path
                                                        : '/images/no-image.png'
                                                "
                                                alt=""
                                                class="img-fluid"
                                                width="335"
                                            />
                                        </template>
                                        <div class="group_price" v-if="estate.renovation_type != 'カスタム可能物件'">
                                            <div class="g-bg">
                                                <div class="g-bg_item bg-black"></div>
                                                <p class="total_price">
                                                    {{ estate.price }}<span class="unit">万円</span
                                                    ><span class="sub">リノベ済</span>
                                                </p>
                                            </div>
                                            <template v-if="estate.estate_information">
                                                <div class="g-bg" v-if="estate.estate_information.estate_fee == 1">
                                                    <div class="g-bg_item bg-gray"></div>
                                                    <p class="price_info">仲介手数料無料</p>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="group_price" v-else>
                                            <div class="g-bg">
                                                <div class="g-bg_item bg-black"></div>
                                                <p class="total_price">
                                                    {{ estate.price }}<span class="unit">万円</span
                                                    ><span class="sub">（改装前価格）</span>
                                                </p>
                                            </div>
                                            <template v-if="estate.estate_information">
                                                <div class="g-bg" v-if="estate.estate_information.estate_fee == 1">
                                                    <div class="g-bg_item bg-gray"></div>
                                                    <p class="price_info">仲介手数料無料</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </a>
                                <div class="w_property-archive_head">
                                    <a v-bind:href="'/detail/' + estate._id"> </a>
                                    <div class="property-archive_head">
                                        <a v-bind:href="'/detail/' + estate._id">
                                            <div class="property_info">
                                                <template v-if="estate.estate_information">
                                                    <p class="property_name">
                                                        {{ estate.estate_information.article_title }}
                                                    </p>
                                                </template>
                                                <p class="property_address">
                                                    <span>
                                                        {{ estate.address.city }}{{ estate.address.ooaza
                                                        }}{{ estate.address.tyoume }} {{ estate.tatemono_menseki }}m² /
                                                        {{ estate.room_count }}{{ estate.room_kind }}
                                                    </span>
                                                </p>
                                            </div>
                                        </a>
                                        <div class="property_wishlist">
                                            <template v-if="accessToken">
                                                <a v-if="estate._id">
                                                    <WishlistComponent
                                                        :estate-id="estate._id"
                                                        :data-wished="estate.is_wish"
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
                        @getListEstates="getListEstates"
                    ></PaginationComponent>
                    <div class="listing_top button-search-condition">
                        <div class="container">
                            <div class="listing_sort">
                                <div class="border-0 pl-0 search_number"></div>
                                <ul>
                                    <li>
                                        <button type="button" class="btn btn-filter black" v-on:click="goSearchPage">
                                            <i class="c-icon i-filter-white"></i>
                                            条件を変更する
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
        let conditionSearch = this.$getLocalStorage('conditionSearch')
            ? JSON.parse(this.$getLocalStorage('conditionSearch'))
            : [];
        let tabListActived = conditionSearch.tabSesarch ? conditionSearch.tabSesarch : [];
        let urlRedirect = this.$route.fullPath;
        let pageChoice = 1;
        return {
            estates: [],
            page: 2,
            offsetTop: 0,
            heigthOfList: 0,
            hasMore: true,
            accessToken: false,
            conditionSearch: {},
            total: 0,
            tabListActived: tabListActived,
            urlRedirect: urlRedirect,
            paginationInfo: [],
            pageChoice: pageChoice
        };
    },
    components: {
        WishlistComponent: () => import('../components/WishlistComponent'),
        PaginationComponent: () => import('../components/PaginationComponent')
    },
    created() {
        this.$store.registerModule('estate', estateModule);
        window.addEventListener('scroll', this.handleScroll);
        window.onload = function () {
            window.onpopstate = function () {
                window.location.reload();
            };
        };
        this.getListEstates(this.pageChoice);
    },
    beforeDestroy() {
        this.$store.unregisterModule('estate');
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        // Gui yeu cau den server sau moi lan cuon xuong
        getListEstates(pageLoad) {
            // this.$setLocalStorage('pageChoice', pageLoad);
            let accessToken = this.$getLocalStorage('accessToken');
            let flagSearch = this.$getLocalStorage('tabActive') ? this.$getLocalStorage('tabActive') : 'area';
            let conditionSearch = this.$getLocalStorage('conditionSearch')
                ? JSON.parse(this.$getLocalStorage('conditionSearch'))
                : [];
            let minPrice = this.$route.query.minPrice;
            let maxPrice = this.$route.query.maxPrice;
            let minSquare = this.$route.query.minSquare;
            let maxSquare = this.$route.query.maxSquare;
            let tabSearch = this.$route.query.tabSearch ? this.$route.query.tabSearch : this.tabListActived;
            let tabSearchName = this.$route.query.tabSearchName;
            let parentIdSelected = this.$getLocalStorage('parentIdSelected')
                ? JSON.parse(this.$getLocalStorage('parentIdSelected'))
                : '';
            let parentNameSelected = this.$getLocalStorage('parentNameSelected')
                ? JSON.parse(this.$getLocalStorage('parentNameSelected'))
                : '';

            let data = {
                limit: 16,
                page: pageLoad,
                flag_search: flagSearch
            };

            if (conditionSearch.districts) {
                data.districts = Array.isArray(conditionSearch.districts)
                    ? conditionSearch.districts
                    : [conditionSearch.districts];
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

            if (parentIdSelected) {
                data.parent_id_selected = parentIdSelected;
            }

            if (parentNameSelected) {
                data.parent_name_selected = parentNameSelected;
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
                    .then((res) => {
                        // this.estates = this.estates.concat(res[0]['data']);
                        this.estates = res[0]['data'];
                        this.paginationInfo = res[0]['paginationInfo'];
                        this.conditionSearch = res[0]['conditionSearch'];
                        this.total = res[0]['total'];
                        if (this.estates.length < res[0].total) {
                            this.hasMore = true;
                        } else {
                            this.hasMore = false;
                        }

                        let keyword =
                            this.conditionSearch.key_word != '指定なし' ? this.conditionSearch.key_word + ',' : '';
                        let price = '';
                        let square = '';
                        if (
                            this.conditionSearch.price.min != '下限なし' &&
                            this.conditionSearch.price.max != '上限なし'
                        ) {
                            price += this.conditionSearch.price.min + '～' + this.conditionSearch.price.max + ',';
                        } else if (this.conditionSearch.price.min != '下限なし') {
                            price += this.conditionSearch.price.min + '～,';
                        } else if (this.conditionSearch.price.max != '上限なし') {
                            price += '～' + this.conditionSearch.price.max + ',';
                        }

                        if (
                            this.conditionSearch.square.min != '下限なし' &&
                            this.conditionSearch.square.max != '上限なし'
                        ) {
                            square += this.conditionSearch.square.min + '～' + this.conditionSearch.square.max + ',';
                        } else if (this.conditionSearch.square.min != '下限なし') {
                            square += this.conditionSearch.square.min + '～,';
                        } else if (this.conditionSearch.square.max != '上限なし') {
                            square += '～' + this.conditionSearch.square.max;
                        }

                        let string = keyword + price + square;
                        this.$emit('title-dynamic', string);
                    })
                    .catch((err) => {
                        this.$setCookie('accessToken3d', '', 1);
                        this.$removeAuthLocalStorage();
                        this.$removeLocalStorage('announcement_count');
                    });
            } else {
                this.$store
                    .dispatch('getEstateList', data)
                    .then((res) => {
                        let stringTitle = [];
                        // this.estates = this.estates.concat(res[0]['data']);
                        this.estates = res[0]['data'];
                        this.conditionSearch = conditionSearch = res[0]['conditionSearch'];
                        this.paginationInfo = res[0]['paginationInfo'];
                        this.total = res[0]['total'];
                        if (this.estates.length < res[0].total) {
                            this.hasMore = true;
                        } else {
                            this.hasMore = false;
                        }

                        let keyword = '';

                        let price = '';
                        let square = '';
                        let tagName = '';
                        if (this.conditionSearch.key_word) {
                            keyword = this.conditionSearch.key_word != '指定なし' ? this.conditionSearch.key_word : '';
                            stringTitle.push(keyword);
                        }
                        if (this.conditionSearch.price) {
                            if (
                                this.conditionSearch.price.min != '下限なし' &&
                                this.conditionSearch.price.max != '上限なし'
                            ) {
                                price += ' ' + this.conditionSearch.price.min + '～' + this.conditionSearch.price.max;
                            } else if (this.conditionSearch.price.min != '下限なし') {
                                price += ' ' + this.conditionSearch.price.min + '～';
                            } else if (this.conditionSearch.price.max != '上限なし') {
                                price += ' ～' + this.conditionSearch.price.max;
                            }
                            stringTitle.push(price);
                        }

                        if (this.conditionSearch.square) {
                            if (
                                this.conditionSearch.square.min != '下限なし' &&
                                this.conditionSearch.square.max != '上限なし'
                            ) {
                                square +=
                                    ' ' + this.conditionSearch.square.min + '～' + this.conditionSearch.square.max;
                            } else if (this.conditionSearch.square.min != '下限なし') {
                                square += ' ' + this.conditionSearch.square.min + '～';
                            } else if (this.conditionSearch.square.max != '上限なし') {
                                square += ' ～' + this.conditionSearch.square.max;
                            }
                            stringTitle.push(square);
                        }

                        if (this.conditionSearch.tab_search_name) {
                            tagName = ' ' + this.conditionSearch.tab_search_name;
                            stringTitle.push(tagName);
                        }
                        this.$emit('title-dynamic', stringTitle.join());
                    })
                    .catch((err) => {
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

            // if (document.scrollingElement.scrollTop > this.offsetTop && this.hasMore) {
            //     this.getListEstates(this.page);
            //     this.setOffsetTop();
            //     this.page++;
            // }
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
                    .catch((err) => {
                        this.$setCookie('accessToken3d', '', 1);
                        this.$removeAuthLocalStorage();
                        this.$removeLocalStorage('announcement_count');
                        this.$router.push({ name: 'login' }).catch(() => {});
                    });
            }
        },

        goSearchPage() {
            return this.$router.push('/search').catch(() => {});
        }
    }
};
</script>
