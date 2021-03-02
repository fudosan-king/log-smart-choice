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
                                    <form autocomplete="off" @submit.prevent="login" class="frm_login">
                                        <div class="form-group">
                                            <label for="">メールアドレス（※）</label>
                                            <input type="email" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">パスワード（※）</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                v-model="password"
                                                placeholder="パスワードを確認する"
                                            />
                                            <smal class="notice_password"
                                                >8文字以上で、文字、数字、記号を含む必要があります。</smal
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label for="">パスワード確認（※）</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                v-model="password"
                                                placeholder="パスワードを確認する"
                                            />
                                            <smal class="notice_password"
                                                >8文字以上で、文字、数字、記号を含む必要があります。</smal
                                            >
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
                                    <button class="login_btn login_btn--google border">
                                        Googleでログイン
                                    </button>
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
export default {
    data() {
        return {
            email: null,
            password: null,
            errors: [],
            errorsApi: {}
        };
    }
    // methods: {
    //     login() {
    //         this.errors = [];
    //         if (!this.email) {
    //             this.errors.push('メールアドレスを入力してください');
    //         } else if (!this.validEmail(this.email)) {
    //             this.errors.push('Valid email required.');
    //         }

    //         if (!this.password) {
    //             this.errors.push('パスワードを入力してください');
    //         }
    //         if (!this.errors.length) {
    //             let email = this.email;
    //             let password = this.password;
    //             this.$store
    //                 .dispatch('login', { email, password })
    //                 .then(response => {
    //                     this.$router.push('/');
    //                     this.$router.go(0);
    //                 })
    //                 .catch(error => {
    //                     let responseErrors = error.response.data;
    //                     let errors = {};
    //                     if (typeof error.response.data != 'object') {
    //                         errors = JSON.parse(responseErrors);
    //                         for (var key in errors) {
    //                             errors[key] = errors[key][0];
    //                         }
    //                     } else {
    //                         errors['error'] = responseErrors['message'];
    //                     }

    //                     this.errorsApi = errors;
    //                 });
    //         }
    //     },

    //     validEmail(email) {
    //         var response = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //         return response.test(email);
    //     }
    // }
};
</script>
