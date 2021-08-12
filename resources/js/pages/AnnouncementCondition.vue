<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">メルマガ配信希望条件</h2>
                        <p class="subtitle subtitle-announcement-condition mb-2">
                            <small
                                >あなたのご希望条件にマッチした物件をメールでいち早くお知らせします。</small
                            >
                        </p>
                    </div>
                </div>
            </section>

            <section class="section_accinfo bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="frm_accinfo">
                                <h4>エリア（複数選択可）</h4>
                                <ul class="list_area">
                                    <li v-for="district in districts" :key="district.id">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input district-input"
                                                :id="'ck0' + district.id"
                                                name="districtInput[]"
                                                :value="district.name"
                                                :checked="checkedDistrictInput.includes(district.name) ? 'checked' : ''"
                                            />
                                            <label class="custom-control-label" :for="'ck0' + district.id">{{
                                                district.name
                                            }}</label>
                                        </div>
                                    </li>
                                </ul>
                                <h4>価格（万円）</h4>
                                <div class="row">
                                    <div class="col-6 col-lg-6">
                                        <div class="box_select">
                                            <select class="custom-select" v-model="minTotalPrices" :class="{
                                                    'is-invalid': errorsApi.total_price && errorsApi.total_price.length
                                                }">
                                                <option
                                                    v-for="price in totalPrices"
                                                    :value="price"
                                                    :selected="price == minTotalPrices ? 'selected' : ''"
                                                    >{{ price }}</option
                                                >
                                            </select>
                                            <div
                                                v-if="errorsApi.total_price && errorsApi.total_price.length"
                                                class="invalid-feedback"
                                            >
                                                <span>
                                                    {{ errorsApi.total_price[0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6">
                                        <select class="custom-select" v-model="maxTotalPrices">
                                            <option
                                                v-for="price in totalPrices"
                                                :value="price"
                                                :selected="price == maxTotalPrices ? 'selected' : ''"
                                                v-if="price != 0"
                                                >{{ price }}</option
                                            >
                                        </select>
                                    </div>
                                </div>

                                <h4>広さ（m2）</h4>
                                <div class="row">
                                    <div class="col-6 col-lg-6">
                                        <div class="box_select">
                                            <select class="custom-select" v-model="minSquare" :class="{
                                                    'is-invalid': errorsApi.square && errorsApi.square.length
                                                }">
                                                <option
                                                    v-for="square in squares"
                                                    :value="square"
                                                    :selected="square == minSquare ? 'selected' : ''"
                                                    >{{ square }}</option
                                                >
                                            </select>
                                            <div
                                                v-if="errorsApi.square && errorsApi.square.length"
                                                class="invalid-feedback"
                                            >
                                                <span>
                                                    {{ errorsApi.square[0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6">
                                        <select class="custom-select" v-model="maxSquare">
                                            <option
                                                v-for="square in squares"
                                                :value="square"
                                                :selected="square == maxSquare ? 'selected' : ''"
                                                v-if="square != 0"
                                                >{{ square }}</option
                                            >
                                        </select>
                                    </div>
                                </div>

                                <button type="button" class="btn btnsave my-5" v-on:click="submit">保存</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script>
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.all.min.js';

Vue.use(VueSweetalert2);

export default {
    data() {
        return {
            errorsApi: {},
            districts: {},
            totalPrices: [],
            squares: [],
            checkedDistrictInput: [],
            minTotalPrices: 0,
            maxTotalPrices: 500,
            minSquare: 0,
            maxSquare: 10,
            getDistrictList: []
        };
    },
    created() {
        this.listDistrict();
        this.listTotalPrice();
        this.listSquare();

        this.getCustomerInformation();
    },
    methods: {
        listDistrict() {
            this.$store.dispatch('getCustomerDistrict').then(resp => {
                this.districts = resp.data;
            });
        },
        listTotalPrice() {
            let min = 0;
            let max = 10000;
            while (min <= max) {
                this.totalPrices.push(min);
                min = min + 500;
            }
        },
        listSquare() {
            let min = 0;
            let max = 150;
            while (min <= max) {
                this.squares.push(min);
                min = min + 10;
            }
        },

        submit() {
            this.message = [];
            this.submitted = true;
            let newDistrictsList = [];
            $('input:checkbox:checked').each(function(i) {
                newDistrictsList[i] = $(this).val();
            });
            if (this.submitted) {
                let data = {
                    city: newDistrictsList,
                    price: {
                        min: this.minTotalPrices,
                        max: this.maxTotalPrices
                    },
                    square: {
                        min: this.minSquare,
                        max: this.maxSquare
                    }
                };
                var content = 'メルマガ配信希望条件が正常に変更されました！';
                this.$store
                    .dispatch('updateAnnouncement', data)
                    .then(resp => {
                        this.disabled = true;
                        this.$swal('メルマガ配信希望条件', content, 'success').then(result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'information' });
                            }
                        });
                    })
                    .catch(error => {
                        this.disabled = false;
                        this.submitted = false;
                        this.errorsApi = error.response.data.errors.messages[0];
                    });
            }
        },

        getCustomerInformation() {
            this.$store.dispatch('customerInfo').then(resp => {
                if (resp.announcement_condition) {
                    if (resp.announcement_condition.city) {
                        this.getDistrictList = resp.announcement_condition.city;
                    }

                    if (resp.announcement_condition.price) {
                        this.minTotalPrices = resp.announcement_condition.price.min;
                        this.maxTotalPrices = resp.announcement_condition.price.max;
                    }
                    if (resp.announcement_condition.square) {
                        this.minSquare = resp.announcement_condition.square.min;
                        this.maxSquare = resp.announcement_condition.square.max;
                    }
                    this.districts.forEach(element => {
                        if (this.getDistrictList.includes(element.name)) {
                            this.checkedDistrictInput.push(element.name);
                        }
                    });
                }
                
            });
        }
    }
};
</script>
