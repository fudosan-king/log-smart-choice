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
                                            <input type="email" class="form-control" v-model="email" />
                                        </div>
                                        <div class="form-group">
                                            <label>パスワード（※）</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                v-model="password"
                                                placeholder="パスワードを確認する"
                                            />
                                            <p class="notice_password">
                                                8文字以上で、文字、数字、記号を含む必要があります。
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label>パスワード確認（※）</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                v-model="password"
                                                placeholder="パスワードを確認する"
                                            />
                                            <p class="notice_password">
                                                8文字以上で、文字、数字、記号を含む必要があります。
                                            </p>
                                        </div>
                                        <div class="form-group btn_login_submit text-center">
                                            <button type="submit" class="btn btnlogin">申し込む</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col deltail_login_right">
                                    <p class="note_login_btn_social">ソーシャルアカウントでのログインはこちら</p>
                                    <button class="login_btn login_btn--facebook">
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
                                <p>
                                    アカウントをお持ちでしょうか？ &nbsp<a href="#" class="href_login"
                                        >ログインする＞</a
                                    >
                                </p>
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
import { email, maxLength, required, minLength, sameAs } from 'vuelidate/lib/validators';
export default {
    data() {
        return {
            email: null,
            password: null,
            password_confirmation: null,
            errors: [],
            errorsApi: {}
        };
    },
    computed: {
        vuelidate() {
            return this.$v;
        }
    },
    validations: {
        email: {
            required,
            email,
            maxLength: maxLength(255)
        },
        password: {
            required,
            minLength: minLength(8)
        },
        password_confirmation: {
            sameAs: sameAs(function() {
                return this.password;
            })
        }
    },
    methods: {
        isRequired(val) {
            return val !== null && val !== '' && val !== undefined;
        },
        submit() {
            this.errorsApi = {};
            this.vuelidate.$touch();
            if (!this.vuelidate.$invalid) {
            }
        },
        googleLogin() {
            this.$store
                .dispatch('googleLogin')
                .then(response => {
                    this.$setCookie('accessToken', response.token, 1);
                    this.$setCookie('accessToken3d', response.token, 1);
                    this.$setCookie('refreshToken', response.refreshToken, 1);
                    window.location.href = '/';
                })
                .catch(error => {
                    let responseErrors = error.response.data;
                    let errors = {};
                    if (typeof error.response.data != 'object') {
                        errors = JSON.parse(responseErrors);
                        for (var key in errors) {
                            errors[key] = errors[key][0];
                        }
                    } else {
                        errors['error'] = responseErrors['message'];
                    }
                    this.errorsApi = errors;
                });
        }
    }
};
</script>
