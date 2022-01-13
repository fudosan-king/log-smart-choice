<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">新規会員登録</h2>
                        <p class="subtitle subtitle-register mb-2">
                            <small>ようこそOrder-Renoveへ！<br>
                            あなただけの新しい住まい探しはここから</small>
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
                                        <a class="btn" @click="facebookLogin" href="#"><img src="images/svg/i_fb.svg" alt="" class="img-fluid" width="24">Facebookで登録</a>
                                    </li>
                                    <li><a class="btn" @click="googleLogin" href="#"><img src="images/svg/i_google.svg" alt="" class="img-fluid" width="24">Googleで登録</a></li>
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
                                    <label for="">名前 <span class="red">必須</span></label>
                                    <div class="row">
                                        <div class="col-6 col-lg-6 align-self-center">
                                            <input
                                                v-model="customer.name"
                                                type="text"
                                                class="form-control"
                                                placeholder="例：山田"
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
                                                placeholder="例：太郎"
                                                :class="{
                                                    'is-invalid':
                                                    (submitted && $v.customer.last_name.$error) ||
                                                    errorsApi.last_name && errorsApi.last_name.length
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
                                </div>
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
                                    <input 
                                        type="checkbox" 
                                        class="custom-control-input" 
                                        id="customCheck1" 
                                        v-model="checkboxConfirm"
                                        :class="{
                                            'is-invalid':
                                                (submitted && !$v.checkboxConfirm.checked)
                                        }">
                                    <label class="custom-control-label" for="customCheck1">同意する</label>
                                    <div v-if="submitted && !$v.checkboxConfirm.checked" class="invalid-feedback">
                                        <span>プライバシーポリシーをチェックしてください</span>
                                    </div>
                                </div>
                                <div class="form-group btn_login_submit text-center">
                                    <button type="submit" class="btn btnsave" :disabled="disabled">会員登録</button>
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
import globalVaiable from '../globalHelper';

Vue.use(globalVaiable);

export default {
    data() {
        return {
            customer: {
                email: null,
                password: null,
                password_confirmation: '',
                name: null,
                last_name: null,
            },
            errors: [],
            errorsApi: {},
            submitted: false,
            disabled: false,
            checkboxConfirm: false,
        };
    },
    validations: {
        customer: {
            name: {
                required,
            },
            last_name: {
                required,
            },
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
        },
        checkboxConfirm : {
            checked(val) {
                return val;
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
                axios
                    .post('/register', this.customer, {
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => {
                        this.$setLocalStorage('emailRegister', this.customer.email);
                        this.$router.push({ name: 'registerThankYou' }).catch(() => {});
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
    },
    metaInfo: {
        titleTemplate: '新規会員登録｜Order Renove'
    }
};
</script>
