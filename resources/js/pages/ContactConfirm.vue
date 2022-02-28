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
                                            物件名 : {{ contactData.estateName }} <br />
                                            お名前 : {{ contactData.name + ' ' + contactData.lastName }} <br />
                                            メールアドレス : {{ contactData.email }} <br />
                                            電話番号 : {{ convertPhone(contactData.landLine) }} <br />
                                            第1希望日時 : {{ contactData.hopeDayFirst }} <br />
                                            第2希望日時 : {{ contactData.hopeDaySecond }} <br />
                                            気になるご質問 : {{ contactData.inquiryContent }}
                                        </h5>
                                        <p class="text-center mb-0 mt-5">
                                            <a href="/contact" class="btn d-inline-block">戻る</a>
                                            <a
                                                href="javascript:void(0)"
                                                @click="successContact"
                                                class="btn d-inline-block mr-0"
                                                >送信する</a
                                            >
                                        </p>
                                        <!-- Do not change class, action, method. -->
                                        <form class="formrun d-none" action="#" method="post" id="postToFormrun">
                                            <!-- ↓You can add/change fields. -->

                                            <div>
                                                <label>物件名</label>
                                                <input name="物件名" type="text" :value="contactData.estateName" />
                                            </div>

                                            <div>
                                                <label>第1希望日時</label>
                                                <input
                                                    name="第1希望日時"
                                                    type="text"
                                                    :value="contactData.hopeDayFirst + ' ' + contactData.startTimeFirst"
                                                />
                                            </div>

                                            <div>
                                                <label>第2希望日時</label>
                                                <input
                                                    name="第2希望日時"
                                                    type="text"
                                                    :value="
                                                        contactData.hopeDaySecond + ' ' + contactData.startTimeSecond
                                                    "
                                                />
                                            </div>

                                            <div>
                                                <label>お名前</label>
                                                <input
                                                    name="お名前"
                                                    type="text"
                                                    :value="contactData.name + ' ' + contactData.lastName"
                                                />
                                            </div>

                                            <div>
                                                <label>メールアドレス</label>
                                                <input name="メールアドレス" type="text" :value="contactData.email" />
                                            </div>

                                            <div>
                                                <label>電話番号</label>
                                                <input
                                                    name="電話番号"
                                                    type="text"
                                                    :value="convertPhone(contactData.landLine)"
                                                />
                                            </div>

                                            <div>
                                                <label>電話番号</label>
                                                <textarea
                                                    name="気になるご質問"
                                                    type="text"
                                                    :value="contactData.inquiryContent"
                                                />
                                            </div>

                                            <div>
                                                <label>EstateUrl</label>
                                                <input name="estate_url" :value="contactData.estateUrl" />
                                            </div>

                                            <div>
                                                <label>OrderRenoveCustomerId</label>
                                                <input name="orderrenove_customer_id" :value="contactData.estateUrl" />
                                            </div>

                                            <div>
                                                <label>Checked Privacy</label>
                                                <input type="checkbox" name="プライバシーポリシー" checked />
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
            contactData: {}
        };
    },
    created() {
        this.getContactData();
    },
    methods: {
        getContactData() {
            if (window.localStorage.getItem('contactData').length > 0) {
                this.contactData = JSON.parse(window.localStorage.getItem('contactData'));
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
            $('input[name="物件名"]').val(this.contactData.estateName);
            $('input[name="第1希望日時"]').val(this.contactData.hopeDayFirst + ' ' + this.contactData.startTimeFirst);
            $('input[name="第2希望日時"]').val(this.contactData.hopeDaySecond + ' ' + this.contactData.startTimeSecond);
            $('input[name="お名前"]').val(this.contactData.name + ' ' + this.contactData.lastName);
            $('input[name="メールアドレス"]').val(this.contactData.email);
            $('input[name="電話番号"]').val(this.contactData.landLine);
            $('input[name="estate_url"]').val(this.contactData.estateUrl);
            $('textarea[name="第1希望日時"]').val(this.contactData.inquiryContent);
            $('input[name="orderrenove_customer_id"]').val(this.contactData.orderRenoveCustomerID);
            window.localStorage.setItem('orderrenoveCustomerId', this.contactData.orderRenoveCustomerID);
            this.$setCookie('orderrenoveCustomerId', this.contactData.orderRenoveCustomerID, 1);
            window.localStorage.removeItem('estate_id');
            if (window.localStorage.getItem('accessToken')) {
                window.localStorage.removeItem('contactData');
                $('#postToFormrun').attr('action', 'https://form.run/api/v1/r/9ms3izrtap72ulo9ztochng5');
            } else {
                $('#postToFormrun').attr('action', 'https://form.run/api/v1/r/qthnyoi9k8q7h63zt1dqbi26');
            }
            $('#postToFormrun').submit();
        }
    },
    metaInfo: {
        titleTemplate: 'への 内見・お問い合わせ確認｜Order Renove'
    }
};
</script>
