<template>
    <div>
        <template>
            <div>
                <main>
                    <div class="box_template">
                        <section class="p-0">
                            <div class="box_top mb-0">
                                <div class="container">
                                    <h2 class="title mb-3">確認</h2>
                                </div>
                            </div>
                        </section>

                        <section class="section_contact">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <form class="frm_contact" action="#" method="post">
                                            <!-- confirm -->
                                            <div class="box_confirm">
                                                <div class="frm_general_content frm_confirm mt-3" style="">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td width="50%">
                                                                    <label>物件名 </label>
                                                                </td>
                                                                <td class="confirm-text">
                                                                    <span id="date">{{ contactData.estateName }}</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="50%">
                                                                    <label>第1希望日時</label>
                                                                </td>
                                                                <td class="confirm-text">
                                                                    <span id="date">{{
                                                                        contactData.hopeDayFirst
                                                                    }}</span>
                                                                    <span id="time">{{
                                                                        contactData.startTimeFirst
                                                                    }}</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <label>第2希望日時</label>
                                                                </td>
                                                                <td class="confirm-text">
                                                                    <span id="date">{{
                                                                        contactData.hopeDaySecond
                                                                    }}</span>
                                                                    <span id="time">{{
                                                                        contactData.startTimeSecond
                                                                    }}</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <label>お名前</label>
                                                                </td>
                                                                <td id="full_name" class="confirm-text">
                                                                    <span>{{ contactData.name + ' ' + contactData.lastName}}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label>メールアドレス</label>
                                                                </td>
                                                                <td id="email" class="confirm-text">
                                                                    <span>{{ contactData.email }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label>電話番号</label>
                                                                </td>
                                                                <td id="phone-number" class="confirm-text">
                                                                    <span>{{
                                                                        convertPhone(contactData.landLine)
                                                                    }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label>気になるご質問</label>
                                                                </td>
                                                                <td id="inquiry_content" class="confirm-text">
                                                                    <span>{{ contactData.inquiryContent }}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="box_content_footer mt-4">
                                                        <div class="form-group text-center">
                                                            <div class="row">
                                                                <div class="col-12 col-lg-6">
                                                                    <a href="/contact" class="btn btn_back"
                                                                        ><img
                                                                            src="/assets/images/svg/i_left_white.svg"
                                                                            alt=""
                                                                            class="img-fluid"
                                                                            width="10"
                                                                        />
                                                                        戻る</a
                                                                    >
                                                                </div>
                                                                <div class="col-12 col-lg-6">
                                                                    <a
                                                                        class="btn btn_send"
                                                                        @click="successContact"
                                                                        data-toggle="modal"
                                                                        >送信する
                                                                        <img
                                                                            src="/assets/images/svg/i_right_white.svg"
                                                                            alt=""
                                                                            class="img-fluid"
                                                                            width="10"
                                                                    /></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- Do not change class, action, method. -->
                                        <form
                                            class="formrun d-none"
                                            action="#"
                                            method="post"
                                            id="postToFormrun"
                                        >
                                            <!-- ↓You can add/change fields. -->

                                            <div>
                                                <label>物件名</label>
                                                <input
                                                    name="物件名"
                                                    type="text"
                                                    :value="contactData.estateName"
                                                />
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
                                                <input name="お名前" type="text" :value="contactData.name + ' ' + contactData.lastName" />
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
                                                <input name="estate_url" type="text" :value="contactData.estateUrl" />
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
                                                <input type="checkbox" name="プライバシーポリシー" checked/>
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
    mounted() {
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
    }
};
</script>
