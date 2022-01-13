<template>
    <main>
        <div class="bg-white">
            <section class="p-0">
                <div class="box_top mb-0 bg-transparent">
                    <div class="container">
                        <h2 class="title">物件問い合わせ完了</h2>
                    </div>
                </div>
            </section>

            <section class="section_top_template pt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <p>
                                お問い合わせいただき、ありがとうございますご入力いただいたメールアドレスに、お問い合わせ完了メールをお送りいたしました。<br />
                                後ほど、（株）LogSuiteの担当者よりご連絡申し上げます。
                            </p>
                            <p class="text-center mb-0 mt-5">
                                <a class="btn d-inline-block mr-0" href="javascript:void(0)" v-on:click="backHome"
                                    >トップに戻る
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script>
export default {
    methods: {
        backHome() {
            this.$router.push('/').catch(() => {});
        }
    },
    metaInfo: {
        titleTemplate: 'プラン名｜Order Renove'
    }
};
</script>
