<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 m-auto">
                            <h2>ログイン</h2>
                            <form autocomplete="off" @submit.prevent="login" class="frm_login">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 align-self-center">
                                            <label class="font-weight-bold" for="">メールアドレス（※）</label>
                                        </div>
                                        <div class="col-12 col-lg-8 align-self-center">
                                            <input
                                                class="form-control"
                                                placeholder="例：xxxxxxx@hchinokanri.co.jp"
                                                v-model="customer.email"
                                                :class="{
                                                    'is-invalid':
                                                        (submitted && $v.customer.email.$error) ||
                                                        (errors && errors.length)
                                                }"
                                            />
                                            <div v-if="submitted && $v.customer.email.$error" class="invalid-feedback">
                                                <span v-if="!$v.customer.email.required">メールが必要です</span>
                                                <span v-if="!$v.customer.email.email">メールが無効です</span>
                                            </div>
                                            <div class="invalid-feedback" v-if="errors.email">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <label class="font-weight-bold" for="">パスワード（※）</label>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <input
                                                type="password"
                                                class="form-control"
                                                v-model="customer.password"
                                                :class="{
                                                    'is-invalid':
                                                        (submitted && $v.customer.password.$error) ||
                                                        (errors && errors.length)
                                                }"
                                            />
                                            <div class="text-danger" v-for="error in errors.password">
                                                <small>{{ error }}</small>
                                            </div>
                                            <div class="text-danger" v-for="error in errors.messages">
                                                <small>{{ error }}</small>
                                            </div>
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

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btnlogin">ログイン</button>
                                                <div class="text-center">
                                                    <div class="text-center">
                                                        <router-link :to="{ name: 'forgotPassword' }">
                                                            パスワードを忘れた場合
                                                        </router-link>
                                                    </div>
                                                    <div class="text-center">
                                                        <router-link :to="{ name: 'reconfirmEmail' }">
                                                            確認メールが届いてない場合
                                                        </router-link>
                                                    </div>
                                                    <div class="text-center">
                                                        <router-link :to="{ name: 'register' }">
                                                            新規会員登録
                                                        </router-link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
<script>
import gAuth from '../config/googleAuth';
import FBAuth from '../config/facebookAuth';
import Vue from 'vue';
import { required, email, minLength, maxLength } from 'vuelidate/lib/validators';

const gAuthOption = {
    clientId: process.env.MIX_GOOGLE_CLIENT_ID,
    scope: "profile email",
    jsSrc: "https://apis.google.com/js/api.js",
};

Vue.use(gAuth, gAuthOption);

const fbAuthOption = {
    appID: process.env.MIX_FACEBOOK_APP_ID,
    jsID: "facebook-jssdk",
    jsSrc: "https://connect.facebook.net/en_US/sdk.js",
    version: "v10.0",
};

Vue.use(FBAuth, fbAuthOption);

export default {
    data() {
        return {
            customer: {
                email: null,
                password: null
            },
            errors: {},
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
            }
        }
    },
    methods: {
        login() {
            this.submitted = true;
            this.errors = {};
            this.$v.$touch();
            if (!this.$v.$invalid && this.submitted) {
                let email = this.customer.email;
                let password = this.customer.password;
                this.submitted = false;
                this.$store
                    .dispatch('login', { email, password })
                    .then(response => {
                        this.$router.push('/');
                        this.$router.go(0);
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
};
</script>
