<template>
    <div>
        <main>
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">資料請求・内見</h2>
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
                                                    <label for="">物件名</label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <p class="mb-0">
                                                        <span>{{ estate }}</span>
                                                    </p>
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
                                                    <div
                                                        v-if="submitted && $v.name.$error"
                                                        class="invalid-feedback"
                                                    >
                                                        <span v-if="!$v.name.required"
                                                            >名前を入力してください。</span
                                                        >
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
                                                <div class="col-12 col-lg-3 align-self-center">
                                                    <label for="">第1希望日時</label>
                                                </div>
                                                <div class="col-12 col-lg-9 align-self-center">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <select name="hope_day_first" class="custom-select">
                                                                <template v-for="hopeDay in listHopeDay">
                                                                    <option v-if="hopeDay"
                                                                        :value="hopeDay"
                                                                        :selected="
                                                                            contactData.hopeDayFirst == hopeDay
                                                                                ? 'selected'
                                                                                : ''
                                                                        "
                                                                        >{{ hopeDay }}</option
                                                                    >
                                                                </template>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-12 col-lg-6">
                                                            <select name="start_time_first" class="custom-select">
                                                                <option
                                                                    v-for="startTime in listStartTime"
                                                                    :value="startTime"
                                                                    :selected="
                                                                        contactData.startTimeFirst == startTime
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >{{ startTime }}</option
                                                                >
                                                            </select>
                                                        </div> -->
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
                                                                <template v-for="hopeDay in listHopeDay">
                                                                    <option v-if="hopeDay"
                                                                        :value="hopeDay"
                                                                        :selected="
                                                                            contactData.hopeDaySecond == hopeDay
                                                                                ? 'selected'
                                                                                : ''
                                                                        "
                                                                        >{{ hopeDay }}</option
                                                                    >
                                                                </template>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-12 col-lg-6">
                                                            <select name="start_time_second" class="custom-select">
                                                                <option
                                                                    v-for="startTime in listStartTime"
                                                                    :value="startTime"
                                                                    :selected="
                                                                        contactData.startTimeSecond == startTime
                                                                            ? 'selected'
                                                                            : ''
                                                                    "
                                                                    >{{ startTime }}</option
                                                                >
                                                            </select>
                                                        </div> -->
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
                                                <div class="custom-control custom-checkbox">
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
                name: '',
                last_name: '',
                land_line: '',
                errorMessage: {},
                contactData: {},
                inquiryContent: '',
                hopeDayFirst: '',
                hopeDaySecond: '',
                startTimeFirst: '',
                startTimeSecond: '',
                listHopeDay: [],
                listStartTime: [],
                checkedPrivacy: '',
                orderrenoveCustomerId: ''
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
            }
        },
        mounted() {
            if (window.localStorage.getItem('estateName')) {
                this.estate = window.localStorage.getItem('estateName');
            }
            this.getCustomerInformation();
            this.getListHopeDay();
            this.getListStartTime();
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
                        if (window.localStorage.getItem('contactData')) {
                            this.contactData = JSON.parse(window.localStorage.getItem('contactData'));
                            this.land_line = this.contactData.landLine;
                            this.name = this.contactData.name;
                            this.last_name = this.contactData.lastName;
                            this.email = this.contactData.email;
                            this.inquiryContent = this.contactData.inquiryContent;
                            this.hopeDayFirst = this.contactData.hopeDayFirst;
                            this.hopeDaySecond = this.contactData.hopeDaySecond;
                            this.startTimeFirst = this.contactData.startTimeFirst;
                            this.startTimeSecond = this.contactData.startTimeSecond;
                            this.checkedPrivacy = this.contactData.checkedPrivacy;
                        }
                    })
                    .catch(() => {
                        this.estate = window.localStorage.getItem('estateName');
                        this.orderrenoveCustomerId = this.randomOrderRenoveCustomerId(10);
                        if (window.localStorage.getItem('contactData')) {
                            this.contactData = JSON.parse(window.localStorage.getItem('contactData'));
                            this.land_line = this.contactData.landLine;
                            this.name = this.contactData.name;
                            this.last_name = this.contactData.lastName;
                            this.email = this.contactData.email;
                            this.inquiryContent = this.contactData.inquiryContent;
                            this.hopeDayFirst = this.contactData.hopeDayFirst;
                            this.hopeDaySecond = this.contactData.hopeDaySecond;
                            this.startTimeFirst = this.contactData.startTimeFirst;
                            this.startTimeSecond = this.contactData.startTimeSecond;
                            this.checkedPrivacy = this.contactData.checkedPrivacy;
                        }
                    });
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
                    data.email = this.email;
                    data.name = this.name;
                    data.lastName = this.last_name;
                    data.landLine = this.land_line;
                    data.inquiryContent = inquiryContent;
                    data.estateUrl = window.location.origin + '/detail/' + window.localStorage.getItem('estate_id');
                    data.hopeDayFirst = hopeDayFirst;
                    data.hopeDaySecond = hopeDaySecond;
                    data.startTimeFirst = startTimeFirst;
                    data.startTimeSecond = startTimeSecond;
                    data.estateName = this.estate;
                    data.checkedPrivacy = 'on';
                    data.orderRenoveCustomerID = orderRenoveCustomerID;
                    window.localStorage.setItem('contactData', JSON.stringify(data));
                    this.$router.push('contact/confirm').catch(() => {});
                }
            },

            getListStartTime() {
                let listStartTime = ['10:00', '12:00', '14:00', '16:00'];
                this.listStartTime = listStartTime;
            },

            getListHopeDay() {
                let days = [];
                var today = new Date();
                for (let index = 0; index <= 6; index++) {
                    // if (this.formatDay(today) !== 'undefined') {
                        days.push(this.formatDay(today));
                    // }
                }
                days = [
                    '1月06日 (木)',
                    '1月07日 (金)',
                    '1月08日 (土)'
                ];
                this.listHopeDay = days;
            },

            formatDay(today) {
                let currentDate = today.setDate(today.getDate() + 1);
                let newDate = new Date(currentDate);
                let dd = String(newDate.getDate()).padStart(1, '0');
                let mm = String(newDate.getMonth() + 1).padStart(1, '0'); //January is 0!
                let dayOfWeek = newDate.getDay(); // Sunday is 0, Monday is 1, and so on.
                let dayKind = '';
                if (dayOfWeek != 2 && dayOfWeek != 3) {
                    switch (dayOfWeek) {
                        case 0:
                            dayKind = '日';
                            break;
                        case 1:
                            dayKind = '月';
                            break;
                        case 2:
                            dayKind = '火';
                            break;
                        case 3:
                            dayKind = '水';
                            break;
                        case 4:
                            dayKind = '木';
                            break;
                        case 5:
                            dayKind = '金';
                            break;
                        case 6:
                            dayKind = '土';
                            break;
                        default:
                            break;
                    }
                }
                if (dayKind) {
                    return mm + '月' + dd + '日 ' + '(' + dayKind + ')';
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
            }
        }
    };
</script>
