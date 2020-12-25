<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 offset-lg-2">
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
                                                v-text="errorsApi.email"
                                                v-if="errorsApi.email"
                                            ></div>
                                            <div
                                                class="alert alert-danger"
                                                v-text="errorsApi.password"
                                                v-if="errorsApi.password"
                                            ></div>
                                            <br />
                                            <div
                                                class="alert alert-danger"
                                                v-text="errorsApi.error"
                                                v-if="errorsApi.error"
                                            ></div>
                                            <div v-if="errors.length">
                                                <div class="alert alert-danger" v-for="error in errors">
                                                    {{ error }}
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btnlogin">ログイン</button>
                                            <p class="text-center">
                                                <a href="#">パスワードを忘れた場合</a><br />
                                                <a href="#">確認メールが届いてない場合</a><br />
                                                <a href="#">新規会員登録</a>
                                            </p>
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
            var url = '/customer/login';
            var params = {
                email: this.email,
                password: this.password,
                // remember: this.remember
            };
            this.errors = [];
            var self = this;
            if (!this.email) {
                this.errors.push('メールアドレスを入力してください');
            } else if (!this.validEmail(this.email)) {
                this.errors.push('Valid email required.');
            }

            if (!this.password) {
                this.errors.push('パスワードを入力してください');
            }
            if (!this.errors.length) {
                axios
                    .post(url, params)
                    // .then(function(response) {
                    //     console.log('then');
                    //     console.log(response);
                        // self.errors = {};
                    // })
                    .catch(function(error) {
                        console.log('haere');
                        console.log(error);
                        // var responseErrors = error.response.data;
                        // var errors = {};
                        // if (typeof responseErrors != 'object') {
                        //     errors = JSON.parse(responseErrors);
                        //     for (var key in errors) {
                        //         errors[key] = errors[key][0];
                        //     }
                        // } else {
                        //     errors['error'] = responseErrors['message'];
                        // }
                        // self.errorsApi = errors;
                    });
            }
        },

        // login: function() {
        //     let email = this.email;
        //     let password = this.password;
        //     console.log('here06');
        //     this.$store
        //         .dispatch('login', { email, password })
        //         .then((response) => {
        //              this.$router.push('/');
        //             console.log('then');
        //             })
        //         .catch(error => {
        //             console.log('here05');
        //             if (error.responseErrors && error.responseErrors.data) {
        //                 var responseErrors = error.response.data;
        //                 var errors = {};
        //                 if (typeof responseErrors != 'object') {
        //                     errors = JSON.parse(responseErrors);
        //                     for (var key in errors) {
        //                         errors[key] = errors[key][0];
        //                     }
        //                 } else {
        //                     errors['error'] = responseErrors['message'];
        //                 }
        //                 self.errorsApi = errors;
        //             }
        //         });
        // },

        validEmail(email) {
            var response = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return response.test(email);
        }
    }
};
</script>
