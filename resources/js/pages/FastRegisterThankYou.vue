<template>
    <main>
        <div class="bg-white">
            <section class="p-0">
                <div class="box_top mb-0 bg-transparent">
                    <div class="container">
                        <h2 class="title mb-2 mt-4">会員登録申請完了</h2>
                    </div>
                </div>
            </section>

            <section class="section_top_template pt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <h3 class="text-center">ご登録ありがとうございます。</h3>
                            <h5>
                                送信先：<a :href="'mailto:' + email"></a>{{ email }}<br />
                                上記のメールアドレスに仮登録のご案内メールを送信いたしました。記載されているURLを24時間以内にクリックし、登録を完了してください。
                            </h5>
                            <p>
                                メールが届かない場合は、メールアドレスが間違っている可能性があります。お手数ですが、メールアドレスを確認の上、再度会員登録お願いいたします。
                            </p>
                            <p>
                                ドメイン指定受信をご利用の方は、<a href="https://order-renove.jp/">order-renove.jp</a
                                >のドメインからのメールが受信できるよう設定変更をお願いします。
                            </p>
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
    methods: {
        gotoTopPage() {
            this.$removeLocalStorage('emailRegister');
            this.$router.push({ name: 'home' }).catch(() => {});
        }
    }
};
</script>
