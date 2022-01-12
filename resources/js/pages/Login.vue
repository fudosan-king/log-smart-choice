<template>
    <div>
        <main id="main">
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">ログイン</h2>
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
                                            <a class="btn" @click="facebookLogin">
                                                <img src="images/svg/i_fb.svg" alt class="img-fluid" width="24" />
                                                Facebookでログイン
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn" @click="googleLogin">
                                                <img src="images/svg/i_google.svg" alt class="img-fluid" width="24" />
                                                Googleでログイン
                                            </a>
                                        </li>
                                    </ul>
                                    <p class="or">
                                        <span>または</span>
                                    </p>
                                </div>
                                <form autocomplete="off" @submit.prevent="login" class="frm_settingpass">
                                    <div class="form-group"> 
                                            <div class="">
                                                <label for="">メールアドレス <span class="red">必須</span></label>
                                            </div>
                                            <div class="">
                                                <input
                                                    class="form-control"
                                                    placeholder="orderrenove@propolife.co.jp"
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
                                    <div class="form-group">
                                            <div class="">
                                                <label for="">パスワード  <span class="red">必須</span></label>
                                            </div>
                                            <div class="">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    placeholder="英数字８文字以上"
                                                    v-model="customer.password"
                                                    :class="{
                                                        'is-invalid':
                                                            (submitted && $v.customer.password.$error) ||
                                                            (errors && errors.length)
                                                    }"
                                                />
                                                <div class="text-danger" v-for="error in errors.password" :key="error">
                                                    <small>{{ error }}</small>
                                                </div>
                                                <div class="text-danger" v-for="error in errors.messages" :key="error">
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
                                            </div>
                                    </div>


                                    <!-- <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">入力した情報を保存する</label>
                                    </div> -->

                                    <button type="submit" class="btn btnsave mb-3">ログイン</button>
                                    <p class="text-center red">
                                        <router-link class="d-block" :to="{ name: 'forgotPassword' }">
                                            パスワードを忘れた場合
                                        </router-link>
                                        <router-link class="d-block" :to="{ name: 'reconfirmEmail' }">
                                            確認メールが届いてない場合
                                        </router-link>
                                        <router-link class="d-block" :to="{ name: 'register' }">
                                            新規会員登録
                                        </router-link>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>
<script>
import { required, email, minLength, maxLength } from 'vuelidate/lib/validators';

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
    mounted: function() {
        this.intervalId = setInterval(() => {
            if (window.pageYOffset === 0) {
                clearInterval(this.intervalId);
            }
            window.scroll(0, window.pageYOffset - 50);
        }, 20);
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
                        let urlRedirect = this.$route.query.redirect || '/';
                        this.$router.push(urlRedirect).then(() => {this.$router.go('0');}).catch(() => {});
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
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
        },
    },
    metaInfo: {
        titleTemplate: 'ログイン｜Order Renove'
    }
};
</script>
