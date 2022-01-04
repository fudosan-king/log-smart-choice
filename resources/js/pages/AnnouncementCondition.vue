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
                                <p class="mb-5">あなたのご希望条件にマッチした物件をメールとお知らせ機能でいち早くお知らせします。</p>

                                <h2 class="little_title">エリア（複数選択可）</h2>
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
                                        <option v-if="price != '上限なし'" :value="price" :selected="price == price ? 'selected' : ''">{{ price }}</option>
                                    </template>

                                    </select>
                                    <div
                                        v-if="errorsApi.price && errorsApi.price.length"
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.price[0] }}
                                        </span>
                                    </div>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxTotalPrices">
                                        <template v-for="price in totalPrices">
                                            <option v-if="price != '下限なし'" :value="price" :selected="price == maxTotalPrices ? 'selected' : ''">{{ price }}</option>
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
                                            <option v-if="square != '上限なし'" :value="square" :selected="square == minSquare ? 'selected' : ''">{{ square }}</option>
                                        </template>
                                    </select>
                                    <div
                                        v-if="errorsApi.square && errorsApi.square.length"
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.square[0] }}
                                        </span>
                                    </div>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxSquare">
                                        <template v-for="square in squares">
                                            <option v-if="square != '下限なし'" :value="square" :selected="square == maxSquare ? 'selected' : ''">{{ square }}</option>
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

        <div class="top-more-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>サービス一覧</h3>
                            <div class="row">
                                <div class="col-6">
                                    <p>OrderRenoveについて</p>
                                    <p>リノベプラン一覧</p>
                                    <p>マネーシミュレータ</p>
                                    <p>売却サポート</p>
                                </div>
                                <div class="col-6">
                                    <p>物件一覧</p>
                                    <p>OrderRenove通信</p>
                                    <p>コンシェルジュ相談</p>
                                    <p>会員登録</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>エリアから探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>表参道･青山　麻布･広尾　渋谷･恵比寿･中目黒　目黒･白金高輪　下北沢･三軒茶屋　東横線･目黒線　駒沢･二子玉川　代々木公園　井の頭線　神楽坂　品川・田町　銀座・築地　豊洲清澄・門前仲町　皇居西側　中央線　千駄ヶ谷･四ッ谷　西新宿　東新宿･早稲田　その他</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>人気の駅から探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>表参道駅　乃木坂駅　目黒駅　中目黒駅　代官山駅　恵比寿駅　渋谷駅　三軒茶屋駅　広尾駅　麻布十番駅　六本木駅　品川駅　田町駅　五反田駅　大崎駅</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>こだわりから探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>リノベ済物件　カスタム可能物件　ペット飼育可　ウォークインクローゼット　角部屋　眺望・夜景　セキュリティ充実</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        methods: {
            listDistrict() {
                this.$store.dispatch('getCustomerDistrict').then(resp => {
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
                $('input[name="districtInput[]"]:checked').each(function(i) {
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
                        .then(resp => {
                            this.disabled = true;
                            this.$swal('メルマガ配信希望条件', content, 'success').then(result => {
                                if (result.isConfirmed) {
                                    this.$router.push({ name: 'information' }).catch(() => {});
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
                            this.districts.forEach(element => {
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
