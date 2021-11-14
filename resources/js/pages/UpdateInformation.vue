<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">会員登録情報の変更</h2>
                    </div>
                </div>
            </section>

            <section class="section_accinfo bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="frm_accinfo">
                                <h4>名前 <span>必須</span></h4>
                                <div class="row">
                                    <div class="col-6 col-lg-6 align-self-center">
                                        <input
                                            v-model="customerInfo.name"
                                            type="text"
                                            class="form-control"
                                            placeholder="例：山田"
                                            :class="{
                                                'is-invalid': errorsApi.name && errorsApi.name.length
                                            }"
                                        />
                                        <div v-if="errorsApi.name && errorsApi.name.length" class="invalid-feedback">
                                            <span>
                                                {{ errorsApi.name[0] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-6 col-lg-6 align-self-center">
                                        <input
                                            v-model="customerInfo.last_name"
                                            type="text"
                                            class="form-control"
                                            placeholder="例：太郎"
                                            :class="{
                                                'is-invalid': errorsApi.last_name && errorsApi.last_name.length
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
                                    </div>
                                </div>
                                <h4>メールアドレス <span>必須</span></h4>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="例：xxxxxxxx@orderrenove.jp"
                                    v-model="customerInfo.email"
                                    :class="{
                                        'is-invalid':
                                            (submitted && $v.customerInfo.email.$error) ||
                                            (errorsApi.email && errorsApi.email.length)
                                    }"
                                />
                                <div v-if="submitted && $v.customerInfo.email.$error" class="invalid-feedback">
                                    <span v-if="!$v.customerInfo.email.required">メールが必要です</span>
                                    <span v-if="!$v.customerInfo.email.email">メールが無効です</span>
                                </div>
                                <!-- <h4>電話番号</h4>
                                <input
                                    type="text"
                                    v-model="customerInfo.phone_number"
                                    class="form-control"
                                    placeholder="例：03122255546"
                                    :class="{
                                        'is-invalid': errorsApi.phone_number && errorsApi.phone_number.length
                                    }"
                                />
                                <div
                                    v-if="errorsApi.phone_number && errorsApi.phone_number.length"
                                    class="invalid-feedback"
                                >
                                    <span>
                                        {{ errorsApi.phone_number[0] }}
                                    </span>
                                </div> -->
                                <h4>電話番号</h4>
                                <input
                                    type="text"
                                    v-model="customerInfo.land_line"
                                    class="form-control"
                                    placeholder="例：03122255546"
                                    :class="{
                                        'is-invalid': errorsApi.land_line && errorsApi.land_line.length
                                    }"
                                />
                                <div v-if="errorsApi.land_line && errorsApi.land_line.length" class="invalid-feedback">
                                    <span>
                                        {{ errorsApi.land_line[0] }}
                                    </span>
                                </div>
                                <button type="button" class="btn btnsave my-5" @click="submit()">保存</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script>
import { required, email } from 'vuelidate/lib/validators';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.all.min.js';

Vue.use(VueSweetalert2);

export default {
    data() {
        return {
            errorsApi: {},
            customerInfo: {},
            birthYear: '',
            birthMonth: '',
            birthDay: '',
            submitted: false,
            disabled: false
        };
    },
    mounted: function() {
        this.getCustomer();
    },
    validations: {
        customerInfo: {
            email: {
                required,
                email
            }
        }
    },
    methods: {
        getCustomer() {
            this.$store.dispatch('customerInfo').then(resp => {
                this.customerInfo = resp;
                if (resp.birthday) {
                    this.birthYear = resp.birthday.slice(0, 4);
                    this.birthMonth = resp.birthday.slice(5, 7);
                    this.birthDay = resp.birthday.slice(8, 11);
                }
            });
        },
        submit() {
            this.submitted = true;
            this.$v.$touch();
            this.errorsApi = {};
            if (!this.$v.$invalid && this.submitted) {
                this.submitted = false;
                this.disabled = true;
                var content = '会員情報が正常に変更されました！';
                let data = {
                    name: this.customerInfo.name,
                    last_name: this.customerInfo.last_name,
                    email: this.customerInfo.email,
                    phone_number: this.customerInfo.phone_number,
                    land_line: this.customerInfo.land_line,
                    birthday: {
                        year: this.birthYear,
                        month: this.birthMonth,
                        day: this.birthDay
                    }
                };
                this.$setLocalStorage('userName', data.name, 1);
                this.$store
                    .dispatch('updateInformation', data)
                    .then(resp => {
                        this.$swal('会員情報更新', content, 'success').then(result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'information' }).catch(() => {});
                            }
                        });
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.submitted = false;
                        this.errorsApi = err.response.data.errors.messages[0];
                    });
            }
        }
    },
    updated() {
        $('.datepicker_year')
            .datepicker({
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                language: 'ja'
            })
            .on('change', function() {
                $('.datepicker_year')
                    .val(this.value)[0]
                    .dispatchEvent(new Event('input'));
            });

        $('.datepicker_month')
            .datepicker({
                format: 'mm',
                viewMode: 'months',
                minViewMode: 'months',
                language: 'ja'
            })
            .on('change', function() {
                $('.datepicker_month')
                    .val(this.value)[0]
                    .dispatchEvent(new Event('input'));
            });
        $('.datepicker_day')
            .datepicker({
                format: 'dd',
                viewMode: 'days',
                minViewMode: 'days',
                language: 'ja'
            })
            .on('change', function() {
                $('.datepicker_day')
                    .val(this.value)[0]
                    .dispatchEvent(new Event('input'));
            });
    }
};
</script>
