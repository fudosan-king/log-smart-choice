<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 m-auto">
                            <h2>確認メールの再送信</h2>
                            <p>
                                下記に登録したメールアドレスを入力してください。登録確認のご案内をメールでお送りします。
                            </p>
                            <p>メールアドレス</p>
                            <form autocomplete="off" class="frm_login" @submit.prevent="submit">
                                <div class="form-group">
                                    <input
                                        type="email"
                                        placeholder="例：xxxxxxx@hchinokanri.co.jp"
                                        v-model="email"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': (submitted && $v.email.$error) || (error && error.length)
                                        }"
                                    />

                                    <div v-if="submitted && $v.email.$error" class="invalid-feedback">
                                        <span v-if="!$v.email.required">メールが必要です</span>
                                        <span v-if="!$v.email.email">メールが無効です</span>
                                    </div>
                                    <div class="invalid-feedback" v-for="item in error" :key="item">
                                        {{ item }}
                                    </div>

                                    <div class="valid-feedback d-block" v-for="item in message" :key="item">
                                        {{ item }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 offset-lg-2">
                                            <div class="form-group text-center">
                                                <button
                                                    type="button"
                                                    class="btn btnlogin "
                                                    @click="reconfirmEmail()"
                                                    :disabled="disabled"
                                                >
                                                    メールを送信する
                                                </button>
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
            error: [],
            disabled: false,
            submitted: false,
            message: []
        };
    },
    validations: {
        email: {
            required,
            email
        }
    },
    methods: {
        reconfirmEmail() {
            this.error = {};
            this.message = {};
            this.submitted = true;
            this.$v.$touch();
            if (!this.$v.$invalid && this.submitted) {
                this.submitted = false;
                axios({ url: '/reconfirmation-email', method: 'POST', data: { email: this.email } })
                    .then(resp => {
                        this.disabled = true;
                        this.message = resp.data.success.messages;
                    })
                    .catch(error => {
                        this.disabled = false;
                        this.error = error.response.data.errors.messages;
                    });
            }
        }
    }
};
</script>
