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
                                後ほど、（株）LogSuiteの担当者よりご連絡申し上げます。<br />
                                以下の「会員登録する」のボタンより、お問い合わせ時の入力内容にて会員登録が可能です。登録後は、お気に入り機能や新着メルマガなどの会員様向けのサービスをご利用いただけます。
                            </p>

                            <p class="text-center mb-0 mt-5">
                                <a class="btn d-inline-block" v-on:click="registerMember"
                                    >会員登録する
                                    <img src="assets/images/svg/i_right_white.svg" alt="" class="img-fluid" width="10"
                                /></a>
                                <a class="btn d-inline-block mr-0" v-on:click="backHome"
                                    >トップに戻る
                                    <img src="assets/images/svg/i_right_white.svg" alt="" class="img-fluid" width="10"
                                /></a>
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
        return {
            customer: {},
            districts: ''
        };
    },
    created() {
        this.listDistrict();
    },
    metaInfo: {
        titleTemplate: 'プラン名｜Order Renove'
    },
    methods: {
        backHome() {
            this.$router.push('/').catch(() => {});
        },
        registerMember() {
            let contactData = JSON.parse(window.localStorage.getItem('contactData'));
            this.customer.email = contactData.email;
            this.customer.name = contactData.name;
            this.customer.last_name = contactData.lastName;
            this.customer.send_announcement = 1;
            this.customer.price = {
                min: '下限なし',
                max: '上限なし'
            };
            this.customer.square = {
                min: '下限なし',
                max: '上限なし'
            };
            this.customer.city = Object.keys(this.districts).map((key) => this.districts[key]['name']);

            axios
                .post('/fast-register', this.customer, {
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then((res) => {
                    window.localStorage.removeItem('contactData');
                    this.$setLocalStorage('emailRegister', this.customer.email);
                    this.$router.push({ name: 'fastRegisterThankYou' }).catch(() => {});
                })
                .catch((err) => {
                    this.disabled = false;
                    this.submitted = false;
                    this.errorsApi = err.response.data.errors.messages[0];
                });
        },

        listDistrict() {
            this.$store.dispatch('getCustomerDistrict').then((resp) => {
                this.districts = resp.data;
            });
        }
    }
};
</script>
