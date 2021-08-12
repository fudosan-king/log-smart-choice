<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">会員登録情報</h2>
                    </div>
                </div>
            </section>

            <section class="section_accinfo bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h4>会員登録情報</h4>
                            <div class="row no-gutters">
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">名前：</p>
                                </div>
                                <div class="col-4 col-lg-6 align-self-center">
                                    <p>{{ customerInfo.name }} {{ customerInfo.last_name }}</p>
                                </div>
                                <div class="col-4 col-lg-2 align-self-center">
                                    <a href="/customer/update" class="btn btnedit">変更</a>
                                </div>
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">メールアドレス：</p>
                                </div>
                                <div class="col-8 col-lg-8 align-self-center">
                                    <p>{{ customerInfo.email ? customerInfo.email : '-/-' }}</p>
                                </div>
                                <!-- <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">電話番号：</p>
                                </div>
                                <div class="col-8 col-lg-8 align-self-center">
                                    <p>{{ convertPhone(customerInfo.phone_number) }}</p>
                                </div> -->
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">携帯番号：</p>
                                </div>
                                <div class="col-8 col-lg-8 align-self-center">
                                    <p>{{ convertPhone(customerInfo.land_line) }}</p>
                                </div>
                                <!-- <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">生年月日：</p>
                                </div>
                                <div class="col-8 col-lg-8 align-self-center">
                                    <p>
                                        {{
                                            customerInfo.birthday
                                                ? moment(customerInfo.birthday).format('YYYY年MM月DD日')
                                                : '-'
                                        }}
                                    </p>
                                </div> -->
                            </div>
                            <h4>メルマガ配信希望条件</h4>
                            <div class="row no-gutters">
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">エリア：</p>
                                </div>
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p>{{ districtList }}</p>
                                </div>
                                <div class="col-4 col-lg-4 align-self-center">
                                    <a href="/customer/announcement-condition" class="btn btnedit">設定</a>
                                </div>
                                <div class="col-4 col-lg-4">
                                    <p class="head">広さ：</p>
                                </div>
                                <div class="col-8 col-lg-8">
                                    <p>{{ square }}</p>
                                </div>
                                <div class="col-4 col-lg-4">
                                    <p class="head">価格：</p>
                                </div>
                                <div class="col-8 col-lg-8">
                                    <p>{{ priceTotal }}</p>
                                </div>
                            </div>
                            <h4>パスワード</h4>
                            <div class="row no-gutters">
                                <div class="col-4 col-lg-4 align-self-center">
                                    <p class="head">{{ customerInfo.has_password ? '**************' : '未設定' }}</p>
                                </div>
                                <div class="col-8 col-lg-8 align-self-center">
                                    <a href="/customer/change-password" class="btn btnedit">設定</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script>
import moment from 'moment';

export default {
    data() {
        return {
            customerInfo: '',
            moment,
            districtList: '-/-',
            priceTotal: '-/-',
            square: '-/-'
        };
    },
    mounted() {
        this.getCustomerInformation();
    },
    methods: {
        getCustomerInformation() {
            this.$store.dispatch('customerInfo').then(resp => {
                this.customerInfo = resp;
                if (resp.announcement_condition) {
                    let district = resp.announcement_condition.city;
                    let price = resp.announcement_condition.price;
                    let square = resp.announcement_condition.square;
                    if (district === null) {
                        this.districtList = '-/-';
                    } else {
                        let i = 1;
                        let count = district.length;
                        this.districtList = '';
                        district.forEach(element => {
                            if (i != count) {
                                this.districtList += element + ', ';
                            } else {
                                this.districtList += element;
                            }
                            i++;
                        });
                    }

                    if (price === null) {
                        this.priceTotal = '-/-';
                    } else {
                        this.priceTotal = price.min + '~' + price.max;
                    }

                    if (square === null) {
                        this.square = '-/-';
                    } else {
                        this.square = square.min + '~' + square.max;
                    }
                }
            });
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
        }
    }
};
</script>
