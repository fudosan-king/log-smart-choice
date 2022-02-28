<template>
    <div>
        <main id="main">
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">ようこそOrder Renoveへ！</h2>
                            <p class="subtitle mb-2">
                                <small
                                    >会員登録が完了しました。<br />
                                    下のボタンからログインしてください。</small
                                >
                            </p>
                        </div>
                    </div>
                </section>
                <section class="section_pass">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <input
                                    type="hidden"
                                    :class="{
                                        'is-invalid': submitted && error.length
                                    }"
                                />
                                <div v-if="submitted && error.length" class="invalid-feedback text-center">
                                    <span>{{ error[0] }}</span>
                                </div>
                                <a
                                    class="btn btnsave"
                                    @click="verifyEmail()"
                                    :disabled="disabled"
                                    :class="{ 'd-none': error[0] }"
                                >
                                    ログイン
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            disabled: false,
            submitted: false,
            error: []
        };
    },
    metaInfo: {
        titleTemplate: '会員登録完了｜Order Renove'
    },
    methods: {
        verifyEmail() {
            this.submitted = true;
            const verify = this.$route.params.verify;
            let data = {
                token: verify
            };
            this.$store
                .dispatch('verifyEmail', data)
                .then((resp) => {
                    this.disabled = true;
                    this.$router.push({ name: 'login' }).catch(() => {});
                })
                .catch((error) => {
                    this.disabled = true;
                    this.error = error.response.data.errors.messages;
                    setTimeout(() => {
                        this.$router.push({ name: 'login' }).catch(() => {});
                    }, 2000);
                });
        }
    }
};
</script>
