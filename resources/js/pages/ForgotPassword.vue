<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 m-auto">
                            <h2>パスワード再設定</h2>
                            <p>下記に登録したメールアドレスを入力してください。パスワード再設定のご案内をメールでお送りします。</p>
                            <p>メールアドレス</p>
                            <form autocomplete="off"  class="frm_login">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 align-self-center">
                                            <input
                                                type="email"
                                                class="form-control"
                                                placeholder="例：xxxxxxx@hchinokanri.co.jp"
                                                v-model="email"
                                            />
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12 col-lg-12 col-md-12 align-self-center">
                                            <div v-if="errors.length">
                                                <div class="alert alert-danger" v-for="error in errors">
                                                    {{ error }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 offset-lg-2">
                                            <div class="form-group text-center">
                                                <button type="button" class="btn btnlogin " @click="forgotPassword()" :disabled="disabled">
                                                    >メールを送信する
                                                </button>
                                                <p class="text-center">
                                                    <router-link :to="{name: 'login'}">
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
export default {
    data() {
        return {
            email: null,
            errors: [],
            disabled: false,
        };
    },
    methods: {
        forgotPassword() {
            this.disabled = true ;
            this.errors = [];
            if (!this.email) {
                this.errors.push('メールアドレスを入力してください');
                this.disabled = false ;
            } else if (!this.validEmail(this.email)) {
                this.errors.push('メールが必要です.');
                this.disabled = false ;
            }
            if (!this.errors.length) {
                axios.post("/forgot-password", {email: this.email}, {
                    headers: {
                        'content-type': 'application/json',
                    },
                }).then(res => {
                    this.disabled = false ;
                    if (res.data.status == true) {
                        this.$router.push({name: 'login'});
                    } else{
                        this.errors.push(res.data.message);
                    }
                })
            }
        },
        validEmail(email) {
            var response = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return response.test(email);
        }
    },
}
;
</script>
