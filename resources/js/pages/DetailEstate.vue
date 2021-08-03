<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <p class="subtitle mb-2">
                            <template v-if="estate.estate_information">
                                <small v-if="estate.estate_information.renovation_media[0]"
                                    v-html="estate.estate_information.renovation_media[0].description">
                                </small>
                            </template>
                            
                        </p>
                    </div>
                </div>
            </section>

            <section class="p-0 section_carousel">
                <div class="carousel_property">
                    <div
                        class="carousel carousel-main"
                        data-flickity='{"contain": true, "prevNextButtons": false, "pageDots": false }'
                    >
                        <div class="carousel-cell" v-for="photo in mainPhoto">
                            <img
                                :src="photo.url_path ? photo.url_path : '/images/no-image.png'"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                    <div
                        class="carousel carousel-nav"
                        data-flickity='{"asNavFor": ".carousel-main", "contain": true, "prevNextButtons": false, "pageDots": false }'
                    >
                        <div class="carousel-cell" v-for="photo in mainPhoto">
                            <img
                                :src="photo.url_path ? photo.url_path : '/images/no-image.png'"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <section class="section_property_main">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="box_calcu">
                                <h1>
                                    リノベ＋物件価格
                                    <span>{{ $lscFormatCurrency(estate.total_price ? estate.total_price : estate.price) }}</span
                                    >万円
                                </h1>
                                <form action="" class="frm_calcu">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <p class="text-center d-none d-lg-block">
                                                <span class="title_simulation_result">毎月のお支払例</span>
                                            </p>

                                            <div class="box_simulation_result">
                                                <div class="text-center d-block btn_simulation_result mb-3">
                                                    <h2>{{$lscFormatCurrency(paymentMonthly)}}<span>円</span></h2>
                                                    <!-- <p class="text-right">ボーナス月　＋<span>{{$lscFormatCurrency(paymentMonthlyBonus)}}</span>円</p> -->
                                                </div>
                                                <p class="text-center mt-3">
                                                    <b>管理費：{{ $lscFormatCurrency(estate.management_fee) }}円／修繕積立金：{{ $lscFormatCurrency(estate.repair_reserve_fee) }}円 含む</b>
                                                </p>
                                            </div>

                                            <p class="text-center box_showmore mt-5">
                                                <a  @click="mobileHandleShow" 
                                                    class="btn btnshowhide d-block d-lg-none"
                                                    :class="{ 'show': mobileShow }"></a>
                                            </p>

                                            <div class="w_box_simulation_result" :class="{'show': mobileShow}">
                                                <div class="row no-gutters">
                                                    <div class="col-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label for=""><b>毎月のローン返済額</b></label>
                                                            <!-- <div class="d-flex align-items-center"> -->
                                                                <p class="label_repayment_amount">{{ $lscFormatCurrency(monthlyLoan) }}<span><b>円</b></span></p>
                                                                    <input
                                                                        type="hidden"
                                                                        class="form-control monthly-loan-payment"
                                                                        :value="[[$lscFormatCurrency(monthlyLoan)]]"
                                                                    />
                                                                
                                                            <!-- </div> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><b>ボーナス分返済金額（年2回）</b></label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    ref="lscBonus"
                                                                    v-on:change="changeMoney('lscBonus', $event)"
                                                                    :value="[[$lscFormatCurrency(bonus)]]"
                                                                />
                                                                <span class="ml-2 sub">円/回</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label class="mb-0" for="">管理費</label>
                                                            <h5>{{ $lscFormatCurrency(estate.management_fee) }}<span>円／月</span></h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0" for="">修繕積立金</label>
                                                            <h5>{{$lscFormatCurrency(estate.repair_reserve_fee)}}<span>円／月</span></h5>
                                                        </div>
                                                    </div>
                                                    <pie-chart-component class="col-6 col-sm-6" :parent-data="chartData"></pie-chart-component>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="w_box_simulation_result" :class="{'show': mobileShow}">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">自己資金（頭金）</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    maxlength="4"
                                                                    ref="lscOwnMoney"
                                                                    v-on:change="changeMoney('lscOwnMoney', $event)"
                                                                    :value="[[$lscFormatCurrency(ownMoney)]]"
                                                                />
                                                                <span class="ml-2 sub">万円</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">借入れ額（ローン）</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    maxlength="4"
                                                                    ref="lscBorrowedMoney"
                                                                    v-on:change="changeMoney('lscBorrowedMoney', $event)"
                                                                    :value="[[$lscFormatCurrency(borrowedMoney)]]"
                                                                />
                                                                <span class="ml-2 sub">万円</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-5">
                                                    <input
                                                        type="text"
                                                        class="js-range-slider"
                                                        ref="lscMoneyRange"
                                                        name="my_range"
                                                        value=""
                                                    />

                                                    <!-- <range-slide-component></range-slide-component> -->
                                                </div>
                                                <hr />
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">返済期間</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="number"
                                                                    class="form-control pay-term"
                                                                    ref="lscPaymentTerm"
                                                                    min="0" max="35"
                                                                    v-on:blur="changeMoney('lscPaymentTerm', $event)"
                                                                    :value="[[paymentTerm]]"
                                                                />
                                                                <span class="ml-2 sub">年</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-5">
                                                    <input
                                                        type="text"
                                                        class="js-range-slider1"
                                                        name="my_range"
                                                        value=""
                                                    />
                                                </div>
                                                <hr />
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">金利（元利均等）</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="number"
                                                                    class="form-control interest"
                                                                    ref="lscPaymentInterest"
                                                                    min="0" max="3"
                                                                    v-on:blur="changeMoney('lscPaymentInterest', $event)"
                                                                    :value="[[paymentInterest]]"
                                                                />
                                                                <span class="ml-2 sub">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="text" class="js-range-slider2" name="my_range" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Start Photos -->

                            <div class="box_renovation_specifications">
                                <template v-if="estate.estate_information">
                                    <div
                                        class="specifications_pic"
                                        v-for="(photo, indexPhoto) in estate.estate_information.renovation_media"
                                    >
                                        <img v-if="photo.url_path != '/images/no-image.png'"
                                            v-lazy="photo.url_path ? photo.url_path : '/images/no-image.png'"
                                            alt=""
                                            class="img-fluid"
                                        />
                                        <template v-if="indexPhoto == 0">
                                            <h3 class="estate_name_title">{{ estate.estate_name }}</h3>
                                            <p v-if="estate.address"
                                                >{{ estate.address.pref ? estate.address.pref : ''
                                                }}{{ estate.address.city ? estate.address.city : ''
                                                }}{{ estate.address.ooaza ? estate.address.ooaza : ''
                                                }}{{ estate.address.tyoume ? estate.address.tyoume : ''
                                                }}{{ estate.address.hidden ? estate.address.hidden : '' }}<br />
                                                {{ estate.tatemono_menseki }}m²（{{
                                                    (estate.tatemono_menseki / 3.306).toFixed(2)
                                                }}坪）（壁芯）<br />
                                                1階/RC7階建
                                            </p>
                                        </template>
                                        <template v-else>
                                            <p class="describe" v-html="photo.description"></p>
                                        </template>
                                        
                                    </div>
                                </template>

                                <div class="renovation_specifications_table">
                                    <table class="table">
                                        <tr>
                                            <th>マンション名</th>
                                            <td>{{ estate.estate_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>管理費・修繕積立金</th>
                                            <td>
                                                管理費：{{ $lscFormatCurrency(estate.management_fee) }}円<br />
                                                修繕積立金：{{ $lscFormatCurrency(estate.repair_reserve_fee) }}円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>諸費用・その他制限事項</th>
                                            <template v-if="otherFee.length > 0">
                                                <td>
                                                    <div v-for="fees in otherFee">
                                                        {{ fees.name }} : {{ fees.price }}
                                                    </div>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td>-/-</td>
                                            </template>
                                        </tr>
                                        <tr>
                                            <th>入居時期</th>
                                            <td>{{ estateInfo.time_to_join ? estateInfo.time_to_join : '相談' }}</td>
                                        </tr>
                                        <tr>
                                            <th>構造・階段・所在階・方角</th>
                                            <td>
                                                {{ estate.structure ? estate.structure : '' }}階建{{
                                                    estate.room_floor ? '／' + estate.room_floor + '階' : ''
                                                }}{{ estateInfo.direction ? '／' + estateInfo.direction : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>総戸数</th>
                                            <td>{{ estate.total_houses }}戸</td>
                                        </tr>
                                        <tr>
                                            <th>築年月</th>
                                            <td>
                                                {{
                                                    estate.built_date
                                                        ? moment(parseInt(estate.built_date.$date.$numberLong)).format('YYYY年MM月')
                                                        : ''
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>竣工時売主</th>
                                            <td>{{ estate.motoduke ? estate.motoduke.company : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>施工会社</th>
                                            <td>{{ estate.constructor_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>設計会社</th>
                                            <td>{{ estateInfo.company_design ? estateInfo.company_design : '−' }}</td>
                                        </tr>
                                        <tr>
                                            <th>管理会社・管理形態</th>
                                            <td>
                                                {{ estate.management_company ? estate.management_company + '／' : ''
                                                }}{{ estate.management_scope }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>土地権利</th>
                                            <td>{{ estate.land_rights }}</td>
                                        </tr>
                                        <tr>
                                            <th>用途地域</th>
                                            <td>{{ estate.area_purpose }}</td>
                                        </tr>
                                        <tr>
                                            <th>小学校区域・中学校区域</th>
                                            <td>
                                                {{
                                                    estateInfo.near_primary_high_school
                                                        ? estateInfo.near_primary_high_school
                                                        : '-'
                                                }}
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="map">
                                        <iframe
                                            v-if="estate.latitude && estate.longitude"
                                            :src="srcMap"
                                            width="100%"
                                            height="450"
                                            style="border:0;"
                                            allowfullscreen=""
                                            loading="lazy"
                                        ></iframe>
                                        <iframe
                                            v-else
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.674775952875!2d139.71907221539578!3d35.66038363872215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188b6530fa5ef5%3A0x2c0355e32dbc3abf!2s2-ch%C5%8Dme-24-25%20Nishiazabu%2C%20Minato%20City%2C%20Tokyo%20106-0031%2C%20Nh%E1%BA%ADt%20B%E1%BA%A3n!5e0!3m2!1svi!2s!4v1623202644543!5m2!1svi!2s"
                                            width="100%"
                                            height="450"
                                            style="border:0;"
                                            allowfullscreen=""
                                            loading="lazy"
                                        ></iframe>
                                        <div class="row">
                                            <div class="col-8 col-lg-8">
                                                <p v-if="estate.address">
                                                    {{ estate.address.pref ? estate.address.pref : ''
                                                    }}{{ estate.address.city ? estate.address.city : ''
                                                    }}{{ estate.address.ooaza ? estate.address.ooaza : ''
                                                    }}{{ estate.address.tyoume ? estate.address.tyoume : ''
                                                    }}{{ estate.address.hidden ? estate.address.hidden : '' }}
                                                </p>
                                            </div>
                                            <div class="col-4 col-lg-4">
                                                <p class="text-right">
                                                    <a target="_blank" class="btn_viewmap" href="#">マップで見る</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Photos -->
                            
                        </div>
                    </div>
                </div>
            </section>

            <section class="section_near_property">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h2 class="title">表参道エリアの物件</h2>
                            <template v-if="estate._id">
                                <div>
                                    <estates-near-component :estate-id="estate._id"></estates-near-component>
                                </div>
                            </template>

                            <p class="text-center mt-3">
                                <a class="btn btnSeemore" @click="searchEstateDistrict(estate.address.city)">もっと見る</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script>
import moment from 'moment';
import Lazyload from 'vue-lazyload';
import Vue from 'vue';

Vue.use(Lazyload, {
    preLoad: 1.3,
    error: '../images/no-image.png',
    loading: '../images/loading.gif',
    attempt: 1
});
export default {
    components: {
        EstatesNearComponent: () => import('../components/EstatesNearComponent'),
        PieChartComponent: () => import('../components/PieChartComponent')
    },
    data() {
        return {
            estate: [],
            mainPhoto: '/assets/images/bg_top.jpg',
            slider: [],
            haveEstate: false,
            moment,
            estateInfo: [],
            imageBefore: '',
            imageAfter: '',
            otherFee: [],
            payTerm: '',
            srcMap: '',
            mobileShow: false,
            ownMoney: 0,
            borrowedMoney: 0,
            paymentTerm: 25,
            paymentInterest: 2,
            monthlyLoan: 0,
            paymentMonthly: 0,
            paymentMonthlyBonus: 0,
            bonus: 0,
            chartData: [10,10,80],
            totalPrice: 0,
            mobileFirstTime: true,
        };
    },
    mounted() {
        const payTerm = $('.js-range-slider1');
        payTerm.ionRangeSlider({
            min: 0,
            max: 35,
            from: 25,
            postfix: '年'
        });

        payTerm.on('change', (data) => {
            this.paymentTerm = parseFloat(data.currentTarget.value);
            this.calculateMonthlyLoanPayment();
        });

        const interest = $('.js-range-slider2');
        interest.ionRangeSlider({
            min: 0,
            max: 3,
            from: 2,
            step: 0.1,
            postfix: '%'
        });

        interest.on('change', (data) => {
            this.paymentInterest = parseFloat(data.currentTarget.value);
            this.calculateMonthlyLoanPayment();
        });
        this.getListEstates();
    },
    watch: {
        totalPrice: function(newValue, oldValue) {
            $('.js-range-slider').ionRangeSlider({
                min: 0,
                max: parseInt(newValue),
                step: 100,
                onChange: (data) => {
                    this.ownMoney = data.from;
                    this.borrowedMoney = this.totalPrice - this.ownMoney;
                    this.calculateMonthlyLoanPayment();
                }
            });
        }
    },
    methods: {
        getListEstates() {
            const id = this.$route.params.estateId;
            let data = {};
            if (id.length) {
                data.id = id;
                this.$store.dispatch('getEstate', data).then(resp => {
                    this.estate = resp.data.data.estate[0];
                    window.localStorage.setItem('estateName', this.estate.estate_name);
                    if (this.estate['estate_information']) {
                        if (this.estate['estate_information']['estate_main_photo']) {
                            this.mainPhoto = this.estate['estate_information']['estate_main_photo'];
                        }

                        if (this.estate['other_fee']) {
                            let data = {};
                            this.estate['other_fee'].forEach((element, key) => {
                                if (element.name && element.fee.price) {
                                    data = {
                                        name: element.name,
                                        price: element.fee.price
                                    };
                                    this.otherFee.push(data);
                                }
                            });
                        }
                        this.estateInfo = this.estate['estate_information'];
                        this.borrowedMoney = this.estate.total_price;
                        this.totalPrice = this.estate.total_price;
                        this.calculateMonthlyLoanPayment();
                    }
                    if (this.estate.latitude && this.estate.longitude) {
                        this.srcMap =
                            'https://www.google.com/maps?q=' +
                            this.estate.latitude +
                            ',' +
                            this.estate.longitude +
                            '&output=embed';
                    }
                }).catch(error => {});
            }
        },
        mobileHandleShow() {
            this.mobileShow = !this.mobileShow;
            if (this.mobileFirstTime) {
                this.chartData = [this.estate.management_fee, this.estate.repair_reserve_fee, this.monthlyLoan];
                this.mobileFirstTime = false;
            }
        },

        searchEstateDistrict(district) {
            let cookieStation = this.$getCookie('station');
            if (cookieStation.length > 0) {
                this.$setCookie('station', '', 1);
            }
            this.$setCookie('district', district, 1);
            this.$router
                .push({ name: 'list' })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },
        changeRangeSlider(type, from) {
            let elementClass = '';
            switch(type) {
                case 'ownMoney':
                    elementClass = '.js-range-slider';
                    break;
                case 'paymentTerm':
                    elementClass = '.js-range-slider1'
                    break;  
                case 'paymentInterest':
                    elementClass = '.js-range-slider2';
                    break;  
            }
            if (elementClass.length > 0) {
                $(elementClass).data('ionRangeSlider').update({
                    from: from,
                });
            }
        },
        changeMoney(type, event) {
            event.preventDefault();
            let currentValue = parseFloat(event.target.value);
            switch(type) {
                case 'lscOwnMoney': 
                    if (this.ownMoney == currentValue) {
                        return;
                    }
                    this.ownMoney = currentValue;
                    this.borrowedMoney = this.estate.total_price - this.ownMoney;
                    this.changeRangeSlider('ownMoney', this.ownMoney);
                    break;
                case 'lscBorrowedMoney': 
                    if (this.borrowedMoney == currentValue) {
                        return;
                    }
                    this.borrowedMoney = currentValue;
                    this.ownMoney = this.estate.total_price - this.borrowedMoney;
                    this.changeRangeSlider('ownMoney', this.ownMoney);
                    break;
                case 'lscPaymentTerm': 
                    if (this.paymentTerm == currentValue) {
                        return;
                    }
                    let currentPaymentTerm = currentValue;
                    if (currentPaymentTerm < 0) {
                        this.paymentTerm = 0;
                    }
                    else if (currentPaymentTerm > 35) {
                        this.paymentTerm = 35;
                    } else {
                        this.paymentTerm = currentPaymentTerm;
                    }
                    this.changeRangeSlider('paymentTerm', this.paymentTerm);
                    break;
                case 'lscPaymentInterest': 
                    if (this.paymentInterest == currentValue) {
                        return;
                    }
                    let currentPaymentInterest = currentValue;
                    if (currentPaymentInterest < 0) {
                        this.paymentInterest = 0;
                    } else if (currentPaymentInterest > 3) {
                        this.paymentInterest = 3;
                    } else {
                        this.paymentInterest = currentPaymentInterest;
                    }
                    this.changeRangeSlider('paymentInterest', this.paymentInterest);
                    break;
                case 'lscBonus': 
                    if (this.bonus == currentValue) {
                        return;
                    }
                    this.bonus = currentValue;
                    break;
                default : 
                    break;
            }
            this.calculateMonthlyLoanPayment();
        },
        calculateMonthlyLoanPayment() {
            let interestPercen = this.paymentInterest / 100;
            let paymentTerm12 = this.paymentTerm * 12;
            let interest12 = 1 + (interestPercen / 12);
            let interestWithMonth = Math.pow(interest12, paymentTerm12);
            let calBorrowedMoney = this.borrowedMoney * 10000;

            if (this.paymentTerm <= 0) {
                this.monthlyLoan = calBorrowedMoney;
            } else if (this.paymentInterest <= 0) {
                this.monthlyLoan = Math.ceil(calBorrowedMoney / paymentTerm12);
            } else {
                let sharePart = calBorrowedMoney * (interestPercen / 12) * interestWithMonth;
                let dividedPart = interestWithMonth - 1;
                this.monthlyLoan = Math.ceil((sharePart / dividedPart));
            }
            this.paymentMonthly = Math.ceil(this.monthlyLoan + this.estate.management_fee + this.estate.repair_reserve_fee);
            this.paymentMonthlyBonus = Math.ceil(this.paymentMonthly + (this.bonus / 6));
            this.chartData = [this.estate.management_fee, this.estate.repair_reserve_fee, this.monthlyLoan];
        },
    },
    updated() {
        let estate = this.estate;
        $('.slider-detail').flickity({
            wrapAround: true,
            prevNextButtons: false,
            autoPlay: true
        });
        $('.carousel-main').flickity({
            pageDots: false,
            contain: true,
            prevNextButtons: false
        });
        $('.carousel-nav').flickity({
            asNavFor: '.carousel-main',
            contain: true,
            pageDots: false,
            prevNextButtons: false
        });
    }
};
</script>
