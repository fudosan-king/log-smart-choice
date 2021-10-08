<template>
    <main>
        <div class="box_template">
            <section class="section_accinfo bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h2 class="title mb-2">メルマガ配信希望条件（会員登録）</h2>
                            <p class="text-center mb-3">
                                あなたのご希望条件にマッチした物件をメールでいち早くお知らせします。<br />
                                大手ポータルサイトに載っていない掘り出しものの物件もお届けしています。
                            </p>

                            <form autocomplete="off" class="frm_accinfo" @submit.prevent="submit">
                                <h4>名前 <span>必須</span></h4>
                                <div class="row">
                                    <div class="col-6 col-lg-6 align-self-center">
                                        <input
                                            v-model="customer.name"
                                            type="text"
                                            class="form-control"
                                            placeholder="ゴチャンユイ"
                                            :class="{
                                                'is-invalid':
                                                    (submitted && $v.customer.name.$error) ||
                                                    (errorsApi.name && errorsApi.name.length)
                                            }"
                                        />
                                        <div v-if="errorsApi.name && errorsApi.name.length" class="invalid-feedback">
                                            <span>
                                                {{ errorsApi.name[0] }}
                                            </span>
                                        </div>
                                        <div v-if="submitted && $v.customer.name.$error" class="invalid-feedback">
                                            <span v-if="!$v.customer.name.required">この項目は必須です</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6 align-self-center">
                                        <input
                                            v-model="customer.last_name"
                                            type="text"
                                            class="form-control"
                                            placeholder="アイン"
                                            :class="{
                                                'is-invalid':
                                                    (submitted && $v.customer.last_name.$error) ||
                                                    (errorsApi.last_name && errorsApi.last_name.length)
                                            }"
                                        />
                                        <div
                                            v-if="errorsApi.last_name && errorsApi.last_name.length"
                                            class="invalid-feedback"
                                        >
                                            <span>
                                                {{ errorsApi.last_name[0] }}
                                            </span>
                                        </div>
                                        <div v-if="submitted && $v.customer.last_name.$error" class="invalid-feedback">
                                            <span v-if="!$v.customer.last_name.required">この項目は必須です</span>
                                        </div>
                                    </div>
                                </div>
                                <h4>メールアドレス <span>必須</span></h4>
                                <input
                                    v-model="customer.email"
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid':
                                            (submitted && $v.customer.email.$error) ||
                                            (errorsApi.email && errorsApi.email.length)
                                    }"
                                />
                                <h4>電話番号 <span>必須</span></h4>
                                <input
                                    v-model="customer.land_line"
                                    type="text"
                                    class="form-control"
                                    placeholder="080-3179-2609"
                                    :class="{
                                        'is-invalid':
                                            (errorsApi.land_line && errorsApi.land_line.length) ||
                                            (submitted && $v.customer.land_line.$error)
                                    }"
                                />
                                <div v-if="errorsApi.land_line && errorsApi.land_line.length" class="invalid-feedback">
                                    <span>
                                        {{ errorsApi.land_line[0] }}
                                    </span>
                                </div>
                                <div v-if="submitted && $v.customer.land_line.$error" class="invalid-feedback">
                                    <span v-if="!$v.customer.land_line.required">この項目は必須です</span>
                                </div>
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
                                                        >{{ price }}</option
                                                    >
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
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6">
                                        <select class="custom-select" v-model="maxTotalPrices">
                                            <template v-for="price in totalPrices">
                                                <option
                                                    v-if="price != '下限なし'"
                                                    :value="price"
                                                    :selected="price == maxTotalPrices ? 'selected' : ''"
                                                    >{{ price }}</option
                                                >
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <h4>広さ<i>（m<sup>2</sup>)</i></h4>
                                <div class="row">
                                    <div class="col-6 col-lg-6">
                                        <div class="box_select">
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
                                                        >{{ square }}</option
                                                    >
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
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6">
                                        <select class="custom-select" v-model="maxSquare">
                                            <template v-for="square in squares">
                                                <option
                                                    v-if="square != '下限なし'"
                                                    :value="square"
                                                    :selected="square == maxSquare ? 'selected' : ''"
                                                    >{{ square }}</option
                                                >
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <div class="custom-control custom-checkbox mt-3">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input required"
                                        name="ck_agree"
                                        id="ck_agree"
                                        checked=""
                                    />
                                    <label
                                        class="custom-control-label font-weight-normal ck_agree lbl_ck"
                                        for="ck_agree"
                                        >メールで通知を受け取る
                                    </label>
                                </div>
                                <p class="text_condition text-center mt-3">
                                    ご入力いただいた情報は、当社の<a
                                        class="red font-weight-bold"
                                        href="https://www.propolife.co.jp/privacypolicy"
                                        >プライバシーポリシー</a
                                    >に従って厳重に管理いたします。<br />
                                    下記のプライバシーポリシーを必ずご一読頂き、同意のうえお問い合わせください。
                                </p>
                                <div class="custom-control custom-checkbox mb-3 text-center">
                                    <input
                                        v-model="checkboxConfirm"
                                        type="checkbox"
                                        class="custom-control-input required"
                                        name="ck_condition"
                                        id="ck_condition"
                                        :class="{
                                            'is-invalid': submitted && !$v.checkboxConfirm.checked
                                        }"
                                    />

                                    />
                                    <label
                                        class="custom-control-label font-weight-normal ck_condition lbl_ck"
                                        for="ck_condition"
                                        >同意する</label
                                    >
                                    <div v-if="submitted && !$v.checkboxConfirm.checked" class="invalid-feedback">
                                        <span>プライバシーポリシーをチェックしてください</span>
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btnsave mb-lg-5 font-weight-bold"
                                    data-toggle="modal"
                                    data-target="#modal_info"
                                    :disabled="disabled"
                                >
                                    新規会員登録をして保存
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script>
    import { required, email, minLength, sameAs, maxLength, requiredIf } from 'vuelidate/lib/validators';
    import Vue from 'vue';
    import VueSweetalert2 from 'vue-sweetalert2';
    import globalVaiable from '../globalHelper';
    import 'sweetalert2/dist/sweetalert2.all.min.js';

    Vue.use(globalVaiable);
    Vue.use(VueSweetalert2);

    export default {
        data() {
            return {
                customer: {
                    email: null,
                    land_line: null,
                    name: null,
                    last_name: null
                },
                errorsApi: {},
                submitted: false,
                disabled: false,
                checkboxConfirm: false,
                districts: {},
                totalPrices: [],
                squares: [],
                checkedDistrictInput: [],
                minTotalPrices: '下限なし',
                maxTotalPrices: 1000,
                minSquare: '下限なし',
                maxSquare: 10,
                getDistrictList: [],
                sendAnnouncment: 0
            };
        },
        validations: {
            customer: {
                name: {
                    required
                },
                last_name: {
                    required
                },
                email: {
                    required,
                    email
                },
                land_line: {
                    required
                }
            },
            checkboxConfirm: {
                checked(val) {
                    return val;
                }
            }
        },
        mounted() {
            this.listDistrict();
            this.listTotalPrice();
            this.listSquare();
        },
        methods: {
            submit() {
                this.submitted = true;
                this.$v.$touch();
                this.errorsApi = {};
                if ($('#send_announcement').is(':checked')) {
                    this.sendAnnouncment = 1;
                }
                let newDistrictsList = [];
                $('input[name="districtInput[]"]:checked').each(function(i) {
                    newDistrictsList[i] = $(this).val();
                });
                if (!this.$v.$invalid && this.submitted) {
                    this.submitted = false;
                    this.disabled = true;
                    this.customer.city = newDistrictsList;
                    this.customer.price = {
                        min: this.minTotalPrices,
                        max: this.maxTotalPrices
                    };
                    this.customer.square = {
                        min: this.minSquare,
                        max: this.maxSquare
                    };
                    this.customer.send_announcement = this.sendAnnouncment;
                    var content =
                        '仮登録メール' +
                        this.customer.email +
                        'を送信しました。<br>' +
                        '上記のメールアドレスに仮登録の案内メールを送信しましたので、ご確認ください。<br>' +
                        '記載されているURLを24時間以内にクリックし、登録を完了させてください。';
                    axios
                        .post('/fast-register', this.customer, {
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                        .then(res => {
                            this.$swal('会員登録申請完了', content, 'success').then(result => {
                                if (result.isConfirmed) {
                                    this.$router.push({ name: 'login' }).catch(() => {});
                                }
                            });
                        })
                        .catch(err => {
                            this.disabled = false;
                            this.submitted = false;
                            this.errorsApi = err.response.data.errors.messages[0];
                        });
                }
            },

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
            }
        }
    };
</script>
