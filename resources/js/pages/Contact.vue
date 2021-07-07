<template>
    <div>
        <main>
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">内見・お問い合わせ</h2>
                        </div>
                    </div>
                </section>

                <section class="section_contact">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <form class="frm_contact" method="post">
                                    <input type="hidden" name="logrenove_customer_id" />
                                    <input type="hidden" name="origin_url" value="#" />
                                    <div class="frm-input">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">物件名</label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <p class="mb-0">
                                                        <span>{{ estate.estate_name }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">第1希望日時<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <select name="hope_day_first" class="custom-select">
                                                                <option
                                                                    value="7月1日 (木)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月1日 (木)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月1日 (木)</option
                                                                >
                                                                <option
                                                                    value="7月2日 (金)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月2日 (金)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月2日 (金)</option
                                                                >
                                                                <option
                                                                    value="7月3日 (土)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月3日 (土)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月3日 (土)</option
                                                                >
                                                                <option
                                                                    value="7月4日 (日)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月4日 (日)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月4日 (日)</option
                                                                >
                                                                <option
                                                                    value="7月5日 (月)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月5日 (月)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月5日 (月)</option
                                                                >
                                                                <option
                                                                    value="7月8日 (木)"
                                                                    :selected="
                                                                        contactData.hopeDayFirst == '7月8日 (木)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月8日 (木)</option
                                                                >
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <select name="start_time_first" class="custom-select">
                                                                <option
                                                                    value="10:00"
                                                                    :selected="
                                                                        contactData.startTimeFirst == '10:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >10:00</option
                                                                >
                                                                <option
                                                                    value="12:00"
                                                                    :selected="
                                                                        contactData.startTimeFirst == '12:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >12:00</option
                                                                >
                                                                <option
                                                                    value="14:00"
                                                                    :selected="
                                                                        contactData.startTimeFirst == '14:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >14:00</option
                                                                >
                                                                <option
                                                                    value="16:00"
                                                                    :selected="
                                                                        contactData.startTimeFirst == '16:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >16:00</option
                                                                >
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">第2希望日時</label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <select name="hope_day_second" class="custom-select">
                                                                <option value="7月1日 (木)" selected
                                                                    >7月1日 (木)</option
                                                                >
                                                                <option
                                                                    value="7月2日 (金)"
                                                                    :selected="
                                                                        contactData.hopeDaySecond == '7月2日 (金)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月2日 (金)</option
                                                                >
                                                                <option
                                                                    value="7月3日 (土)"
                                                                    :selected="
                                                                        contactData.hopeDaySecond == '7月3日 (土)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月3日 (土)</option
                                                                >
                                                                <option
                                                                    value="7月4日 (日)"
                                                                    :selected="
                                                                        contactData.hopeDaySecond == '7月4日 (日)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月4日 (日)</option
                                                                >
                                                                <option
                                                                    value="7月5日 (月)"
                                                                    :selected="
                                                                        contactData.hopeDaySecond == '7月5日 (月)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月5日 (月)</option
                                                                >
                                                                <option
                                                                    value="7月8日 (木)"
                                                                    :selected="
                                                                        contactData.hopeDaySecond == '7月8日 (木)'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >7月8日 (木)</option
                                                                >
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <select name="start_time_second" class="custom-select">
                                                                <option
                                                                    value="10:00"
                                                                    :selected="
                                                                        contactData.startTimeSecond == '10:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >10:00</option
                                                                >
                                                                <option
                                                                    value="12:00"
                                                                    :selected="
                                                                        contactData.startTimeSecond == '12:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >12:00</option
                                                                >
                                                                <option
                                                                    value="14:00"
                                                                    :selected="
                                                                        contactData.startTimeSecond == '14:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >14:00</option
                                                                >
                                                                <option
                                                                    value="16:00"
                                                                    :selected="
                                                                        contactData.startTimeSecond == '16:00'
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >16:00</option
                                                                >
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">お名前<span class="red">（※）</span></label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <input
                                                        type="text"
                                                        name="full_name"
                                                        class="form-control"
                                                        placeholder="例：山田 太郎"
                                                        :class="{
                                                            'is-invalid': submitted && $v.full_name.$error
                                                        }"
                                                        v-bind:value="full_name"
                                                        v-on:input="full_name = $event.target.value"
                                                    />
                                                    <div
                                                        v-if="submitted && $v.full_name.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.full_name.required"
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
                                                        placeholder="例：xxxxxxx@logrenove.jp"
                                                        :value="customer.email"
                                                        v-on:input="customer.email = $event.target.value"
                                                        :class="{
                                                            'is-invalid': submitted && $v.customer.email.$error
                                                        }"
                                                    />
                                                    <div
                                                        v-if="submitted && $v.customer.email.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.customer.email.required"
                                                            >名前を入力してください。</span
                                                        >
                                                        <span v-if="!$v.customer.email.email">メールが無効です</span>
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
                                                        name="phone_number"
                                                        placeholder="例：0312341234"
                                                        :value="phone_number"
                                                        v-on:input="phone_number = $event.target.value"
                                                        :class="{
                                                            'is-invalid': submitted && $v.phone_number.$error
                                                        }"
                                                    />
                                                    <div
                                                        v-if="submitted && $v.phone_number.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.phone_number.required"
                                                            >電話番号を入力してください。</span
                                                        >
                                                        <span v-if="!$v.phone_number.minLength || !$v.phone_number.maxLength"
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
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="ck_agree"
                                                        checked=""
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
                                                <button type="button" class="btn btnsave" @click="submitData">
                                                    上記に同意して確認画面へ
                                                    <img
                                                        src="assets/images/svg/i_right_white.svg"
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

                <!-- Do not change class, action, method. -->
                <!-- <form class="formrun" action="https://form.run/api/v1/r/g7jfr70fub07t38hbh1mfo9h" method="post"> -->
                <!-- ↓You can add/change fields. -->
                <!-- <div>
                        <label>お名前</label>
                        <input name="test001" type="text" />
                    </div>

                    <div>
                        <label>メールアドレス [必須]</label>
                        <input name="test002" type="text" data-formrun-type="email" data-formrun-required />
                        <div data-formrun-show-if-error="メールアドレス">メールアドレスを正しく入力してください</div>
                    </div>

                    <div>
                        <label>お問い合わせ [必須]</label>
                        <textarea name="test003" data-formrun-required></textarea>
                        <div data-formrun-show-if-error="お問い合わせ">お問い合わせ入力してください</div>
                    </div>

                    <div>
                        <label>個人情報利用同意 [必須]</label>
                        <input type="checkbox" name="test004" data-formrun-required />
                        <div data-formrun-show-if-error="個人情報利用同意">同意してください</div>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LczNncbAAAAAISz46BAWp4l5aFvln66UheX72it"></div>
                    <button
                        type="submit"
                        data-formrun-error-text="未入力の項目があります"
                        data-formrun-submitting-text="送信中..."
                    >
                        送信
                    </button>
                </form> -->
            </div>
        </main>
    </div>
</template>

<script>
import { required, minLength, maxLength, email } from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            estate: {},
            customer: {},
            submitted: false,
            disabled: false,
            email: '',
            full_name: '',
            phone_number: '',
            errorMessage: {},
            contactData: {},
            inquiryContent: ''
        };
    },
    validations: {
        customer: {
            email: {
                required,
                email
            }
        },
        full_name: {
            required
        },
        phone_number: {
            required,
            minLength: minLength(11),
            maxLength: maxLength(11)
        }
    },
    mounted() {
        this.getEstate();
        this.getCustomerInformation();
        this.getContactData();
    },
    methods: {
        getContactData() {
            if (this.$getCookie('contactData').length > 0) {
            }
        },
        getEstate() {
            let data = {};
            if (this.$getCookie('estate_id').length) {
                data.id = this.$getCookie('estate_id');
                this.$store
                    .dispatch('getEstate', data)
                    .then(resp => {
                        this.estate = resp.data.data.estate[0];
                    })
                    .catch(error => {});
            }
        },

        getCustomerInformation() {
            this.$store
                .dispatch('customerInfo')
                .then(resp => {
                    this.customer = resp;
                    this.full_name = resp.name + ' ' + resp.last_name;
                    this.phone_number = resp.phone_number;
                    if (this.$getCookie('contactData').length > 0) {
                        this.contactData = JSON.parse(this.$getCookie('contactData'));
                        this.phone_number = this.contactData.phoneNumber;
                        this.full_name = this.contactData.fullName;
                        this.customer.email = this.contactData.email;
                        this.inquiryContent = this.contactData.inquiryContent;
                        this.hopeDayFirst = hopeDayFirst;
                        this.hopeDaySecond = hopeDaySecond;
                        this.startTimeFirst = startTimeFirst;
                        this.startTimeSecond = startTimeSecond;
                    }
                })
                .catch(() => {});
        },

        submitData() {
            this.submitted = true;
            this.$v.$touch();
            this.errorMessage = {};
            let hopeDayFirst = $('select[name="hope_day_first"] option:selected').text();
            let hopeDaySecond = $('select[name="hope_day_second"] option:selected').text();
            let startTimeFirst = $('select[name="start_time_first"] option:selected').text();
            let startTimeSecond = $('select[name="start_time_second"] option:selected').text();
            let inquiryContent = $('textarea[name="inquiry_content"]').val();

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
                data.email = this.customer.email;
                data.fullName = this.full_name;
                data.phoneNumber = this.phone_number;
                data.inquiryContent = inquiryContent;
                data.estateUrl = window.location.origin + '/detail/' + this.$getCookie('estate_id');
                data.hopeDayFirst = hopeDayFirst;
                data.hopeDaySecond = hopeDaySecond;
                data.startTimeFirst = startTimeFirst;
                data.startTimeSecond = startTimeSecond;
                this.$setCookie('contactData', JSON.stringify(data), 1);
                this.$router.push('contact/confirm');
            }
        }
    }
};
</script>
