<template>
    <div>
        <main>
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">資料請求</h2>
                        </div>
                    </div>
                </section>

                <section class="section_contact">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <form class="frm_contact" method="post">
                                    <input
                                        type="hidden"
                                        name="orderrenove_customer_id"
                                        v-model="orderrenoveCustomerId"
                                    />
                                    <input type="hidden" name="origin_url" value="#" />
                                    <div class="frm-input">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">プラン名<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <input
                                                        type="text"
                                                        name="plan_name"
                                                        class="form-control"
                                                        placeholder="プラン名"
                                                        :class="{
                                                            'is-invalid': submitted && $v.plan_name.$error
                                                        }"
                                                        v-bind:value="plan_name"
                                                        v-on:input="plan_name = $event.target.value"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">お名前<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-4 align-self-center">
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="form-control"
                                                        placeholder="例：山田"
                                                        :class="{
                                                            'is-invalid': submitted && $v.name.$error
                                                        }"
                                                        v-bind:value="name"
                                                        v-on:input="name = $event.target.value"
                                                    />
                                                    <div v-if="submitted && $v.name.$error" class="invalid-feedback">
                                                        <span v-if="!$v.name.required">名前を入力してください。</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 align-self-center">
                                                    <input
                                                        type="text"
                                                        name="last_name"
                                                        class="form-control"
                                                        placeholder="例：太郎"
                                                        :class="{
                                                            'is-invalid': submitted && $v.last_name.$error
                                                        }"
                                                        v-bind:value="last_name"
                                                        v-on:input="last_name = $event.target.value"
                                                    />
                                                    <div
                                                        v-if="submitted && $v.last_name.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.last_name.required"
                                                            >名前を入力してください。</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">メールアドレス<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <input
                                                        type="text"
                                                        name="email"
                                                        class="form-control"
                                                        placeholder="例：xxxxxxx@order-renove.jp"
                                                        :value="email"
                                                        v-on:input="email = $event.target.value"
                                                        :class="{
                                                            'is-invalid': submitted && $v.email.$error
                                                        }"
                                                    />
                                                    <div v-if="submitted && $v.email.$error" class="invalid-feedback">
                                                        <span v-if="!$v.email.required"
                                                            >メールアドレスを入力してください。</span
                                                        >
                                                        <span v-if="!$v.email.email">メールが無効です</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">電話番号<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="land_line"
                                                        placeholder="例：0312341234"
                                                        :value="land_line"
                                                        v-on:input="land_line = $event.target.value"
                                                        :class="{
                                                            'is-invalid': submitted && $v.land_line.$error
                                                        }"
                                                    />
                                                    <div
                                                        v-if="submitted && $v.land_line.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.land_line.required"
                                                            >電話番号を入力してください。</span
                                                        >
                                                        <span v-if="!$v.land_line.minLength || !$v.land_line.maxLength"
                                                            >電話番号が無効です</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3">
                                                    <label for="">気になるご質問</label>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <textarea
                                                        name="inquiry_content"
                                                        class="form-control"
                                                        placeholder="ご質問やご希望があればご記入ください。"
                                                        :value="inquiryContent"
                                                        v-on:input="inquiryContent = $event.target.value"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="g-recaptcha"
                                            data-sitekey="6LczNncbAAAAAISz46BAWp4l5aFvln66UheX72it"
                                            align="center"
                                        ></div>
                                        <div
                                            v-if="submitted && Object.keys(errorMessage).length > 0"
                                            class="invalid-feedback d-block"
                                        >
                                            <span v-if="typeof errorMessage.recaptcha != 'undefined'">{{
                                                errorMessage.recaptcha
                                            }}</span>
                                        </div>
                                        <div class="box_content_footer">
                                            <p class="primary_policy">
                                                ご入力いただいた情報は、当社のプライバシーポリシーに従って厳重に管理いたします。
                                                個人情報の取扱に関しましては
                                                <a
                                                    target="_blank"
                                                    class="btn-link"
                                                    href="https://www.propolife.co.jp/privacypolicy/"
                                                    rel="noopener noreferrer"
                                                    ><b>プライバシーポリシー</b></a
                                                >
                                                をご覧ください。<br />
                                                ご確認の上、ご同意いただける方は下の「同意する」をチェックしてください。
                                            </p>
                                            <div class="form-group text-center mb-0">
                                                <div class="custom-control custom-checkbox padding-bottom-button">
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="ck_agree"
                                                        :checked="checkedPrivacy == 'on' ? true : false"
                                                        :class="{
                                                            'is-invalid':
                                                                submitted && Object.keys(errorMessage).length > 0
                                                        }"
                                                    />

                                                    <label
                                                        class="custom-control-label font-weight-normal ck_agree"
                                                        for="ck_agree"
                                                        >同意する</label
                                                    >
                                                    <div
                                                        v-if="submitted && Object.keys(errorMessage).length > 0"
                                                        class="invalid-feedback"
                                                    >
                                                        <span
                                                            v-if="typeof errorMessage.checkbox_agree != 'undefined'"
                                                            >{{ errorMessage.checkbox_agree }}</span
                                                        >
                                                    </div>
                                                </div>

                                                <button
                                                    type="button"
                                                    class="btn btn-save-plan-contact"
                                                    @click="submitData"
                                                >
                                                    上記に同意して確認画面へ
                                                    <img
                                                        src="/assets/images/svg/i_right_white.svg"
                                                        alt=""
                                                        class="img-fluid"
                                                        width="10"
                                                    />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>

<script>
import { required, minLength, maxLength, email } from 'vuelidate/lib/validators';
import PagePost from '../store/modules/page-post.js';

export default {
    created() {
        this.$store.registerModule('page-post', PagePost);
    },
    beforeDestroy() {
        this.$store.unregisterModule('page-post');
    },
    data() {
        return {
            customer: {},
            submitted: false,
            disabled: false,
            email: '',
            full_name: '',
            name: '',
            last_name: '',
            land_line: '',
            errorMessage: {},
            planContactData: {},
            inquiryContent: '',
            checkedPrivacy: '',
            orderrenoveCustomerId: '',
            plan_name: ''
        };
    },
    validations: {
        email: {
            required,
            email
        },
        name: {
            required
        },
        last_name: {
            required
        },
        land_line: {
            required,
            minLength: minLength(10),
            maxLength: maxLength(11)
        },
        plan_name: {
            required
        }
    },
    mounted() {
        this.getCustomerInformation();
        this.getPostInformation();
    },
    methods: {
        getCustomerInformation() {
            this.$store
                .dispatch('customerInfo')
                .then(resp => {
                    this.customer = resp;
                    this.name = resp.name;
                    this.last_name = resp.last_name;
                    this.full_name = resp.name + ' ' + resp.last_name;
                    this.email = resp.email;
                    this.land_line = resp.land_line;
                    this.orderrenoveCustomerId = resp.orderrenove_customer_id;
                    if (window.localStorage.getItem('planContactData')) {
                        this.planContactData = JSON.parse(window.localStorage.getItem('planContactData'));
                        this.land_line = this.planContactData.landLine;
                        this.plan_name = this.planContactData.planName;
                        this.name = this.planContactData.name;
                        this.last_name = this.planContactData.lastName;
                        this.email = this.planContactData.email;
                        this.inquiryContent = this.planContactData.inquiryContent;
                        this.checkedPrivacy = this.planContactData.checkedPrivacy;
                    }
                })
                .catch(() => {
                    this.orderrenoveCustomerId = this.randomOrderRenoveCustomerId(10);
                    if (window.localStorage.getItem('planContactData')) {
                        this.planContactData = JSON.parse(window.localStorage.getItem('planContactData'));
                        this.land_line = this.planContactData.landLine;
                        this.plan_name = this.planContactData.planName;
                        this.name = this.planContactData.name;
                        this.last_name = this.planContactData.lastName;
                        this.email = this.planContactData.email;
                        this.inquiryContent = this.planContactData.inquiryContent;
                        this.checkedPrivacy = this.planContactData.checkedPrivacy;
                    }
                });
        },

        submitData() {
            this.submitted = true;
            this.$v.$touch();
            this.errorMessage = {};
            let inquiryContent = $('textarea[name="inquiry_content"]').val();
            let orderRenoveCustomerID = $('input[name="orderrenove_customer_id"]').val();

            if (!$('#ck_agree').prop('checked')) {
                this.errorMessage.checkbox_agree = 'プライバシーポリシーをチェックしてください。';
                return false;
            }
            var recaptcha = $('#g-recaptcha-response').val();
            if (recaptcha === '') {
                this.errorMessage.recaptcha = 'Recapchaをチェックしてください。';
                return false;
            }

            let data = {};
            if (!this.$v.$invalid && this.submitted) {
                data.planName = this.plan_name;
                data.email = this.email;
                data.name = this.name;
                data.lastName = this.last_name;
                data.landLine = this.land_line;
                data.inquiryContent = inquiryContent;
                data.checkedPrivacy = 'on';
                data.orderRenoveCustomerID = orderRenoveCustomerID;
                window.localStorage.setItem('planContactData', JSON.stringify(data));
                this.$router.push('/plan/contact-confirm').catch(() => {});
            }
        },

        randomOrderRenoveCustomerId(length) {
            var result = '';
            var characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },

        getPostInformation() {
            let postId = this.$route.params.postId;
            this.$store
                .dispatch('getPost', postId)
                .then(resp => {
                    this.plan_name = resp.title;
                })
                .catch();
        }
    },
    metaInfo: {
        titleTemplate: 'プラン名｜Order Renove'
    }
};
</script>
