<template>
    <main>
        <div>
            <section class="p-0">
                <div class="box_top mb-0 bg-white">
                    <div class="container">
                        <h2 class="title">メルマガ配信希望条件</h2>
                    </div>
                </div>
            </section>

            <section class="section_search_conditions bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="frm_search_conditions">
                                <p class="mb-5">
                                    あなたのご希望条件にマッチした物件をメールとお知らせ機能でいち早くお知らせします。
                                </p>

                                <h2 class="little_title">エリア（複数選択可）</h2>
                                <ul class="list_area">
                                    <li v-for="district in districts" :key="district.id">
                                        <div class="custom-control custom-checkbox more-space">
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
                                <h2 class="little_title">価格（万円）</h2>
                                <div class="form-group box_form_group">
                                    <select
                                        class="custom-select"
                                        v-model="minTotalPrices"
                                        :class="{
                                            'is-invalid': errorsApi.price && errorsApi.price.length
                                        }"
                                    >
                                        <template v-for="price in totalPrices">
                                            <option
                                                v-if="price != '上限なし'"
                                                :value="price"
                                                :selected="price == price ? 'selected' : ''"
                                            >
                                                {{ price }}
                                            </option>
                                        </template>
                                    </select>
                                    <div v-if="errorsApi.price && errorsApi.price.length" class="invalid-feedback">
                                        <span>
                                            {{ errorsApi.price[0] }}
                                        </span>
                                    </div>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxTotalPrices">
                                        <template v-for="price in totalPrices">
                                            <option
                                                v-if="price != '下限なし'"
                                                :value="price"
                                                :selected="price == maxTotalPrices ? 'selected' : ''"
                                            >
                                                {{ price }}
                                            </option>
                                        </template>
                                    </select>
                                </div>

                                <h2 class="little_title">広さ（m<sup>2</sup>）</h2>
                                <div class="form-group box_form_group">
                                    <select
                                        class="custom-select"
                                        v-model="minSquare"
                                        :class="{
                                            'is-invalid': errorsApi.square && errorsApi.square.length
                                        }"
                                    >
                                        <template v-for="square in squares">
                                            <option
                                                v-if="square != '上限なし'"
                                                :value="square"
                                                :selected="square == minSquare ? 'selected' : ''"
                                            >
                                                {{ square }}
                                            </option>
                                        </template>
                                    </select>
                                    <div v-if="errorsApi.square && errorsApi.square.length" class="invalid-feedback">
                                        <span>
                                            {{ errorsApi.square[0] }}
                                        </span>
                                    </div>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxSquare">
                                        <template v-for="square in squares">
                                            <option
                                                v-if="square != '下限なし'"
                                                :value="square"
                                                :selected="square == maxSquare ? 'selected' : ''"
                                            >
                                                {{ square }}
                                            </option>
                                        </template>
                                    </select>
                                </div>

                                <h2 class="little_title">メール通知設定</h2>
                                <div class="form-group box_form_group">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="send_announcement"
                                            name="sendAnnouncement"
                                            :checked="customerInformation.send_announcement ? 'checked' : ''"
                                        />
                                        <label class="custom-control-label" for="send_announcement"
                                            >メールで通知を受け取る</label
                                        >
                                    </div>
                                </div>

                                <p class="text-center mb-0 mt-3">
                                    <button type="button" class="btn btn_register" v-on:click="submit">選び直す</button>
                                </p>
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
            minTotalPrices: '下限なし',
            maxTotalPrices: 1000,
            minSquare: '下限なし',
            maxSquare: 10,
            getDistrictList: [],
            customerInformation: {},
            sendAnnouncment: 0
        };
    },
    created() {
        this.listDistrict();
        this.listTotalPrice();
        this.listSquare();
        this.getCustomerInformation();
    },
    metaInfo: {
        titleTemplate: 'メルマガ配信希望条件｜Order Renove'
    },
    methods: {
        listDistrict() {
            this.$store.dispatch('getCustomerDistrict').then((resp) => {
                this.districts = resp.data;
            });
        },
        listTotalPrice() {
            let min = 0;
            let max = 20000;
            let i = 0;
            while (min <= max) {
                if (i == 0) {
                    this.totalPrices.push('下限なし');
                } else if (min == max) {
                    this.totalPrices.push(min);
                    this.totalPrices.push('上限なし');
                } else {
                    this.totalPrices.push(min);
                }
                min = min + 1000;
                i++;
            }
        },
        listSquare() {
            let min = 0;
            let max = 150;
            let i = 0;
            while (min <= max) {
                if (i == 0) {
                    this.squares.push('下限なし');
                } else if (min == max) {
                    this.squares.push(min);
                    this.squares.push('上限なし');
                } else {
                    this.squares.push(min);
                }
                min = min + 10;
                i++;
            }
        },

        submit() {
            if ($('#send_announcement').is(':checked')) {
                this.sendAnnouncment = 1;
            }
            this.message = [];
            this.submitted = true;
            let newDistrictsList = [];
            $('input[name="districtInput[]"]:checked').each(function (i) {
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
                    },
                    send_announcement: this.sendAnnouncment
                };
                var content = 'メルマガ配信希望条件が正常に変更されました！';
                this.$store
                    .dispatch('updateAnnouncement', data)
                    .then((resp) => {
                        this.disabled = true;
                        this.$swal('メルマガ配信希望条件', content, 'success').then((result) => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'information' }).catch(() => {});
                            }
                        });
                    })
                    .catch((error) => {
                        this.disabled = false;
                        this.submitted = false;
                        this.errorsApi = error.response.data.errors.messages[0];
                    });
            }
        },

        getCustomerInformation() {
            this.$store.dispatch('customerInfo').then((resp) => {
                this.customerInformation = resp;
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
                    if (this.districts) {
                        this.districts.forEach((element) => {
                            if (this.getDistrictList.includes(element.name)) {
                                this.checkedDistrictInput.push(element.name);
                            }
                        });
                    }
                }
            });
        }
    }
};
</script>
