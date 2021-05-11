<template>
    <div>
        <main id="main">
            <section class="section_register">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <div class="register_title">
                                <h3>ようこそ、Order-Renoveへ！</h3>
                                <span>あなただけの新しい住まいづくりはここから</span>
                            </div>
                            <div class="row">
                                <div class="col deltail_login_left">
                                    <form autocomplete="off" @submit.prevent="submit" class="frm_login">
                                        <div class="form-group">
                                            <label>メールアドレス（※）</label>
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
                                            <label>パスワード（※）</label>
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
                                            <label>パスワード確認（※）</label>
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
                                        <div class="form-group btn_login_submit text-center">
                                            <button type="submit" class="btn btnlogin">申し込む</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col deltail_login_right">
                                    <p class="note_login_btn_social">ソーシャルアカウントでのログインはこちら</p>
                                    <button class="login_btn login_btn--facebook" @click="facebookLogin()">
                                        Facebookでログイン
                                    </button>
                                    <p class="note_login_btn_social"></p>
                                    <button class="login_btn login_btn--google border" @click="googleLogin">
                                        Googleでログイン
                                    </button>
                                    <div
                                        class="alert alert-danger error_api_register"
                                        v-text="errorsApi.error"
                                        v-if="errorsApi.error"
                                    ></div>
                                </div>
                            </div>
                            <hr />
                            <div class="register_footer text-center">
                                <p>アカウントをお持ちでしょうか？ <a href="#" class="href_login">ログインする＞</a></p>
                                <p class="notice_login">
                                    新規登録またはログインして続行することにより、<a href="#" class="href_login"
                                        >Order-Renoveの利用規約</a
                                    >および<a class="href_login">プライバシーポリシー</a>に同意したものとみなされます。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
<script>
import { required, email, minLength, sameAs, maxLength, requiredIf } from 'vuelidate/lib/validators';
import Vue from 'vue';
import globalVaiable from '../globalHelper';

Vue.use(globalVaiable);

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
            submitted: false
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
                axios
                    .post('/register', this.customer, {
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => {
                        this.$router.push({ name: 'login' }, () => {});
                    })
                    .catch(err => {
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
            FB.login(function(response) {
                if (response.authResponse) {
                    store.dispatch('facebookLogin').then(response => {
                        window.location.href = '/';
                    });
                }
            });
            return false;
        }
    }
};
</script>
