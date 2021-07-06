<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">新規会員登録</h2>
                        <p class="subtitle mb-2">
                            <small>ようこそOrder-Renoveへ！<br>
                            あなただけの新しいすまいづくりはここから</small>
                        </p>
                    </div>
                </div>
            </section>
            <section class="section_pass">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="box_toplogin">
                                <ul>
                                    <li>
                                        <a class="btn" @click="facebookLogin" href="#"><img src="images/svg/i_fb.svg" alt="" class="img-fluid" width="24">Facebookでログイン</a>
                                    </li>
                                    <li><a class="btn" @click="googleLogin" href="#"><img src="images/svg/i_google.svg" alt="" class="img-fluid" width="24"> Googleでログイン</a></li>
                                </ul>

                                <div
                                    class="alert alert-danger error_api_register"
                                    v-text="errorsApi.error"
                                    v-if="errorsApi.error"
                                ></div>
                                <p class="or"><span>または</span></p>
                            </div>
                            
                            <form autocomplete="off" @submit.prevent="submit" class="frm_settingpass">
                                <div class="form-group">
                                    <label for="">メールアドレス <span class="red">必須</span></label>
                                    <input
                                        type="text"
                                        v-model="customer.email"
                                        name="email"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                (submitted && $v.customer.email.$error) ||
                                                (errorsApi.email && errorsApi.email.length)
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        v-if="errorsApi.email && errorsApi.email.length"
                                    >
                                        <span>{{ errorsApi.email[0] }}</span>
                                    </div>
                                    <div v-if="submitted && $v.customer.email.$error" class="invalid-feedback">
                                        <span v-if="!$v.customer.email.required">メールが必要です</span>
                                        <span v-if="!$v.customer.email.email">メールが無効です</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">パスワード  <span class="red">必須</span></label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="customer.password"
                                        placeholder="パスワードを確認する"
                                        :class="{
                                            'is-invalid':
                                                (submitted && $v.customer.password.$error) ||
                                                (errorsApi.password && errorsApi.password.length)
                                        }"
                                    />

                                    <div
                                        v-if="submitted && $v.customer.password.$error"
                                        class="invalid-feedback"
                                    >
                                        <span v-if="!$v.customer.password.required"
                                            >パスワードを入力してください
                                        </span>
                                        <span v-if="!$v.customer.password.minLength">
                                            パスワードは8～16文字以内で指定してください
                                        </span>
                                    </div>
                                    <div
                                        v-else-if="errorsApi.password && errorsApi.password.length"
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.password[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">パスワード（再入力） <span class="red">必須</span></label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="customer.password_confirmation"
                                        name="password_confirmation"
                                        placeholder="パスワードを確認する"
                                        :class="{
                                            'is-invalid':
                                                (submitted && $v.customer.password_confirmation.$error) ||
                                                (errorsApi.password_confirmation &&
                                                    errorsApi.password_confirmation.length)
                                        }"
                                    />
                                    <div
                                        v-if="
                                            errorsApi.password_confirmation &&
                                                errorsApi.password_confirmation.length
                                        "
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.password_confirmation[0] }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="submitted && $v.customer.password_confirmation.$error"
                                        class="invalid-feedback"
                                    >
                                        <span v-if="!$v.customer.password_confirmation.required"
                                            >パスワードを入力してください</span
                                        >
                                        <span v-else-if="!$v.customer.password_confirmation.minLength">
                                            パスワードが一致しません
                                        </span>
                                    </div>
                                </div>
                                <p>ご入力いただいた情報は、当社のプライバシーポリシーに従って厳重に管理いたします。<br>
                                    下記の <a href="https://www.propolife.co.jp/privacypolicy" target="blank">プライバシーポリシー</a>  を必ずご一読頂き、同意のうえお問い合わせください。</p>
                                <div class="custom-control custom-checkbox text-center mb-3">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">同意する</label>
                                </div>
                                <div class="form-group btn_login_submit text-center">
                                    <button type="submit" class="btn btnsave" :disabled="disabled">申し込む</button>
                                </div>
                                <p class="text-center red">
                                    <router-link class="d-block" :to="{ name: 'login' }">
                                        ログインに戻る
                                    </router-link>
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
                password: null,
                password_confirmation: ''
            },
            errors: [],
            errorsApi: {},
            submitted: false,
            disabled: false,
        };
    },
    validations: {
        customer: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(8),
                maxLength: maxLength(255)
            },
            password_confirmation: {
                required: requiredIf(function() {
                    return this.customer.password;
                }),
                sameAs: sameAs(function() {
                    return this.customer.password;
                })
            }
        }
    },
    methods: {
        submit() {
            this.submitted = true;
            this.$v.$touch();
            this.errorsApi = {};
            if (!this.$v.$invalid && this.submitted) {
                this.submitted = false;
                this.disabled = true;
                var content =
                    '仮登録メール' +
                    this.customer.email +
                    'を送信しました。<br>' +
                    '上記のメールアドレスに仮登録の案内メールを送信しましたので、ご確認ください。<br>' +
                    '記載されているURLを24時間以内にクリックし、登録を完了させてください。';
                axios
                    .post('/register', this.customer, {
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => {
                        
                        this.$swal('会員登録申請完了', content, 'success').then(result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'login' });
                            }
                        });
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.submitted = false;
                        this.errorsApi = err.response.data.errors;
                    });
            }
        },
        googleLogin() {
            this.$store.dispatch('googleLogin').then(response => {
                window.location.href = '/';
            });
        },

        facebookLogin() {
            const store = this.$store;
            FB.login(
                function(response) {
                    if (response.authResponse) {
                        store.dispatch('facebookLogin').then(response => {
                            window.location.href = '/';
                        });
                    }
                },
                { scope: 'public_profile, email' }
            );
            return false;
        }
    }
};
</script>
