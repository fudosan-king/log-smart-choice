<template>
    <div>
        <main id="main">
            <section class="section_login">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 m-auto text-center">
                            <h2>ようこそ</h2>
                            <p>
                                ご登録完成いたしまた。
                            </p>
                            <p>
                                下のボタンを押してログインしましょう。
                            </p>
                            <form autocomplete="off" class="frm_login" @submit.prevent="submit">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 offset-lg-3">
                                            <div class="form-group text-center">
                                                <button
                                                    type="button"
                                                    class="btn btnlogin "
                                                    @click="verifyEmail()"
                                                    :disabled="disabled"
                                                >
                                                    ログイン
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
export default {
    data() {
        return {
            disabled: false,
            submitted: false
        };
    },
    methods: {
        verifyEmail() {
            const verify = this.$route.params.verify;
            let data = {
                token: verify
            };
            this.$store
                .dispatch('verifyEmail', data)
                .then(resp => {
                    this.disabled = true;
                    this.$router.push({ name: 'login' });
                })
                .catch(error => {
                    this.disabled = false;
                    this.error = error.response.data.errors.messages;
                    this.$router.push({ name: 'login' });
                });
        }
    }
};
</script>
