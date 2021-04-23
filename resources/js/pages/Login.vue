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
                                                type="email"
                                                class="form-control"
                                                placeholder="例：xxxxxxx@hchinokanri.co.jp"
                                                v-model="email"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <label class="font-weight-bold" for="">パスワード（※）</label>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <input type="password" class="form-control" v-model="password" />
                                            <!-- <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                                <label class="custom-control-label" for="customCheck1"
                                                    >入力した情報を保存する</label
                                                >
                                            </div> -->
                                            <br />
                                            <div
                                                class="alert alert-danger"
                                                v-text="errorsApi.email[0]"
                                                v-if="errorsApi.email"
                                            ></div>
                                            <div
                                                class="alert alert-danger"
                                                v-text="errorsApi.password[0]"
                                                v-else-if="errorsApi.password"
                                            ></div>
                                            <div
                                                class="alert alert-danger"
                                                v-text="errorsApi.customer[0]"
                                                v-else-if="errorsApi.customer"
                                            ></div>
                                            <div v-if="errors.length">
                                                <div class="alert alert-danger" v-for="error in errors">
                                                    {{ error }}
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btnlogin">ログイン</button>
                                                <div class="text-center">
                                                    <div class="text-center">
                                                        <router-link :to="{name: 'forgotPassword'}">
                                                            パスワードを忘れた場合
                                                        </router-link>
                                                    </div>
                                                    <div class="text-center">
                                                        <a href="#">確認メールが届いてない場合</a>
                                                    </div>
                                                    <div class="text-center">
                                                        <router-link :to="{name: 'register'}">
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
export default {
    data() {
        return {
            email: null,
            password: null,
            errors: [],
            errorsApi: {}
        };
    },
    methods: {
        login() {
            this.errors = [];
            if (!this.email) {
                this.errors.push('メールアドレスを入力してください');
            } else if (!this.validEmail(this.email)) {
                this.errors.push('メールが必要です.');
            }

            if (!this.password) {
                this.errors.push('パスワードを入力してください');
            }
            if (!this.errors.length) {
                let email = this.email;
                let password = this.password;
                this.$store
                    .dispatch('login', { email, password })
                    .then(response => {
                        this.$router.push('/');
                        this.$router.go(0);
                    })
                    .catch(error => {
                        this.errorsApi = error.response.data.errors;
                    });
            }
        },

        validEmail(email) {
            var response = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return response.test(email);
        }
    }
};
</script>
