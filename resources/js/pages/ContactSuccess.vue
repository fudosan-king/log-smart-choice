<template>
    <div>
        <template>
            <div>
                <main>
                    <div class="box_template">
                        <section class="p-0">
                            <div class="box_top mb-0">
                                <div class="container">
                                    <h1 class="title mb-3">物件お問合せ完了</h1>

                                    <p class="title mb-3"><b>お問い合わせいただき</b></p>
                                    <p class="title mb-3"><b>ありがとうございました。</b></p>
                                    <p class="title mb-3">
                                        ご入力いただいたメールアドレスに、お問合せ完了メールをお送りしました。
                                    </p>
                                    <p class="title mb-3">のちほど担当者よりご連絡申し上げます。</p>
                                    <div class="form-group text-center mb-0 row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6"><button type="button" @click="backHome" class="btn btnsave">オーダーリノベトップに戻る</button></div>
                                        <div class="col-md-3"></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </template>
    </div>
</template>
<script>
export default {
    methods: {
        backHome() {
            this.$router.push("/");
        }
    },
};
</script>
