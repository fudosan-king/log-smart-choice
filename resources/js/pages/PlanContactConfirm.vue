<template>
    <div>
        <template>
            <div>
                <main>
                    <div class="bg-white">
                        <section class="p-0">
                            <div class="box_top mb-0 bg-transparent">
                                <div class="container">
                                    <h2 class="title mb-3">お問い合わせ内容の確認</h2>
                                </div>
                            </div>
                        </section>
                        <section class="section_top_template pt-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-8 m-auto">
                                        <h5>
                                            物件名 : {{ planContactData.planName }} <br />
                                            お名前 : {{ planContactData.name + ' ' + planContactData.lastName }} <br />
                                            メールアドレス : {{ planContactData.email }} <br />
                                            電話番号 : {{ convertPhone(planContactData.landLine) }} <br />
                                            気になるご質問 : {{ planContactData.inquiryContent }}
                                        </h5>
                                        <p class="text-center mb-0 mt-5">
                                            <a href="/plan/contact" class="btn d-inline-block">戻る</a>
                                            <a
                                                href="javascript:void(0)"
                                                @click="successContact"
                                                class="btn d-inline-block mr-0"
                                                >送信する</a
                                            >
                                        </p>
                                        <!-- Do not change class, action, method. -->
                                        <form class="formrun d-none" action="#" method="post" id="postPlanToFormrun">
                                            <!-- ↓You can add/change fields. -->

                                            <div>
                                                <label>プラン名</label>
                                                <input name="planeName" type="text" :value="planContactData.planName" />
                                            </div>

                                            <div>
                                                <label>お名前</label>
                                                <input
                                                    name="name"
                                                    type="text"
                                                    :value="planContactData.name + ' ' + planContactData.lastName"
                                                />
                                            </div>

                                            <div>
                                                <label>メールアドレス</label>
                                                <input name="email" type="text" :value="planContactData.email" />
                                            </div>

                                            <div>
                                                <label>電話番号</label>
                                                <input
                                                    name="landLine"
                                                    type="text"
                                                    :value="convertPhone(planContactData.landLine)"
                                                />
                                            </div>

                                            <div>
                                                <label>お問い合わせ内容</label>
                                                <textarea
                                                    name="inquiryContent"
                                                    type="text"
                                                    :value="planContactData.inquiryContent"
                                                />
                                            </div>

                                            <div>
                                                <label>OrderRenoveCustomerId</label>
                                                <input name="orderrenove_customer_id" :value="planContactData.estateUrl" />
                                            </div>

                                            <div>
                                                <label>プライバシーポリシー</label>
                                                <input type="checkbox" name="check_privacy" checked />
                                            </div>
                                            <button
                                                type="submit"
                                                data-formrun-error-text="未入力の項目があります"
                                                data-formrun-submitting-text="送信中..."
                                            >
                                                送信
                                            </button>
                                        </form>
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
    data() {
        return {
            planContactData: {}
        };
    },
    mounted() {
        this.getContactData();
    },
    methods: {
        getContactData() {
            if (window.localStorage.getItem('planContactData').length > 0) {
                this.planContactData = JSON.parse(window.localStorage.getItem('planContactData'));
            }
        },

        convertPhone(number) {
            let first, second, third;
            if (number) {
                first = number.slice(0, 3);
                second = number.slice(3, 7);
                third = number.slice(7, 12);
                return first + '-' + second + '-' + third;
            } else {
                return '-';
            }
        },

        successContact() {
            $('input[name="planeName"]').val(this.planContactData.planName);
            $('input[name="fullName"]').val(this.planContactData.name + ' ' + this.planContactData.lastName);
            $('input[name="email"]').val(this.planContactData.email);
            $('input[name="landLine"]').val(this.planContactData.landLine);
            $('textarea[name="inquiryContent"]').val(this.planContactData.inquiryContent);
            $('input[name="orderrenove_customer_id"]').val(this.planContactData.orderRenoveCustomerID);
            window.localStorage.setItem('orderrenoveCustomerId', this.planContactData.orderRenoveCustomerID);
            this.$setCookie('orderrenoveCustomerId', this.planContactData.orderRenoveCustomerID, 1);
            window.localStorage.removeItem('estate_id');
            if (window.localStorage.getItem('accessToken')) {
                window.localStorage.removeItem('planContactData');
                $('#postPlanToFormrun').attr('action', 'https://form.run/api/v1/r/c0u029krtmu8wyy0xv89g51g');
            } else {
                $('#postPlanToFormrun').attr('action', 'https://form.run/api/v1/r/5tt50xuysvw88qr4v7rsa099');
            }
            $('#postPlanToFormrun').submit();
        }
    },
    metaInfo: {
        titleTemplate: 'プラン名｜Order Renove'
    }
};
</script>
