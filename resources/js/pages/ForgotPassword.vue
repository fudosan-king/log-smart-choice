<template>
    <div>
        <main id="main">


            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">パスワード再設定</h2>
                            <p class="subtitle mb-2">
                                <small>下記に登録したメールアドレスを入力してください。パスワード再設定のご案内をメールでお送りします。</small>
                            </p>
                        </div>
                    </div>
                </section>

                <section class="section_pass">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <form action="" class="frm_settingpass">
                                    <div class="form-group">
                                        <label for="">メールアドレス <span class="red">必須</span></label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            placeholder="orderrenove@propolife.co.jp"
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

                                    <div class="form-group text-center">
                                        <button
                                            type="button"
                                            class="btn btnsave mb-3"
                                            @click="forgotPassword()"
                                            :disabled="disabled"
                                        >
                                            メールを送信する
                                        </button>
                                        <p class="text-center red">
                                            <router-link class="text-decoration-none" :to="{ name: 'login' }">
                                                ログインに戻る
                                            </router-link>
                                        </p>
                                    </div>
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
                let data = {
                    email: this.email
                };
                this.$store
                    .dispatch('forgotPassword', data)
                    .then(resp => {
                        this.disabled = true;
                        this.message = resp.data.success.messages;
                        setTimeout(() => {
                            this.$router.push({ name: 'login' }).catch(() => {});
                        }, 2000);
                    })
                    .catch(error => {
                        this.disabled = false;
                        this.error = error.response.data.errors.messages;
                    });
            }
        }
    },
    metaInfo: {
        titleTemplate: '忘れたパスワード｜Order Renove'
    }
};
</script>
