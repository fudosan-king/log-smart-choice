<template>
    <main>
        <div class="bg-white">
            <section class="p-0">
                <div class="box_top mb-0 bg-transparent">
                    <div class="container">
                        <h2 class="title mb-2 mt-4">登録完了</h2>
                    </div>
                </div>
            </section>

            <section class="section_top_template pt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <h3 class="text-center mb-4">会員登録が完了いたしました！</h3>
                            <h5>
                                ようこそ！OrderRenoveへ！<br />
                                以下のボタンよりログインいただけます。
                            </h5>
                            <p class="text-center mb-0 mt-5">
                                <a class="btn d-inline-block" href="/register">OrderRenoveとは</a>
                                <a class="btn d-inline-block" v-on:click="gotoTopPage" href="javascript:void(0);"
                                    >トップに戻る</a
                                >
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
    data() {
        let email = this.$getLocalStorage('emailRegister');

        return {
            email: email
        };
    },
    metaInfo: {
        titleTemplate: '会員登録申請完了｜Order Renove'
    },
    methods: {
        gotoTopPage() {
            this.$removeLocalStorage('emailRegister');
            this.$router.push({ name: 'home' }).catch(() => {});
        }
    }
};
</script>
