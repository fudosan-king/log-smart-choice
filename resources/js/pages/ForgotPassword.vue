<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 m-auto">
                            <h2>パスワード再設定</h2>
                            <p>
                                下記に登録したメールアドレスを入力してください。パスワード再設定のご案内をメールでお送りします。
                            </p>
                            <p>メールアドレス</p>
                            <form autocomplete="off" class="frm_login">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 align-self-center">
                                            <input
                                                type="email"
                                                class="form-control"
                                                placeholder="例：xxxxxxx@hchinokanri.co.jp"
                                                v-model="email"
                                                :class="{
                                                    'is-invalid':
                                                        (submitted && $v.email.$error) || (error && error.length)
                                                }"
                                            />
                                            <div v-if="submitted && $v.email.$error" class="invalid-feedback">
                                                <span v-if="!$v.email.required">メールアドレスを入力してください</span>
                                                <span v-if="!$v.email.email">メールが必要です.</span>
                                            </div>
                                            <div class="invalid-feedback" v-for="item in error" :key="item">
                                                {{ item }}
                                            </div>
                                            <div class="valid-feedback d-block" v-for="item in message" :key="item">
                                                {{ item }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 offset-lg-2">
                                            <div class="form-group text-center">
                                                <button
                                                    type="button"
                                                    class="btn btnlogin "
                                                    @click="forgotPassword()"
                                                    :disabled="disabled"
                                                >
                                                    >メールを送信する
                                                </button>
                                                <p class="text-center">
                                                    <router-link :to="{ name: 'login' }">
                                                        ログインに戻る
                                                    </router-link>
                                                </p>
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
import { required, email } from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            email: null,
            error: {},
            disabled: false,
            message: {},
            submitted: false
        };
    },
    validations: {
        email: {
            required,
            email
        }
    },
    methods: {
        forgotPassword() {
            this.error = [];
            this.message = [];
            this.submitted = true;
            this.$v.$touch();
            if (!this.$v.$invalid && this.submitted) {
                axios
                    .post(
                        '/forgot-password',
                        { email: this.email },
                        {
                            headers: {
                                'content-type': 'application/json'
                            }
                        }
                    )
                    .then(res => {
                        this.disabled = true;
                        this.message = res.data.success.messages;
                        setInterval(() => {
                            this.$router.push({ name: 'login' });
                        }, 2000);
                    })
                    .catch(error => {
                        this.error = error.response.data.errors.messages;
                    });
            }
        }
    }
};
</script>
