<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">{{ estate.estate_name }}</h2>
                        <p class="subtitle mb-2">
                            <small v-if="estate.address"
                                >{{ estate.address.pref ? estate.address.pref : ''
                                }}{{ estate.address.city ? estate.address.city : ''
                                }}{{ estate.address.ooaza ? estate.address.ooaza : ''
                                }}{{ estate.address.tyoume ? estate.address.tyoume : ''
                                }}{{ estate.address.hidden ? estate.address.hidden : '' }}<br />
                                {{ estate.tatemono_menseki }}m²（{{
                                    (estate.tatemono_menseki / 3.306).toFixed(2)
                                }}坪）（壁芯）<br />
                                1階/RC7階建</small
                            >
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
                                v-lazy="photo.url_path ? photo.url_path : '/images/no-image.png'"
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
                                v-lazy="photo.url_path ? photo.url_path : '/images/no-image.png'"
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
                                    <span>{{ estate.total_price ? estate.total_price : estate.price }}</span
                                    >万円
                                </h1>
                                <form action="" class="frm_calcu">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <p class="text-center d-none d-lg-block">
                                                <span class="title_simulation_result">シミュレーション結果</span>
                                            </p>

                                            <div class="box_simulation_result">
                                                <div class="row no-gutters">
                                                    <div class="col-6 col-lg-6 align-self-center">
                                                        <h4>毎月のお支払例</h4>
                                                    </div>
                                                    <div class="col-6 col-lg-6 align-self-center">
                                                        <h2>201,089<span>円</span></h2>
                                                        <p class="text-right">ボーナス月　＋<span>０</span>円</p>
                                                    </div>
                                                </div>
                                                <p class="text-center mt-3">
                                                    管理費：20,000円／修繕積立金：20,000円 含む
                                                </p>
                                            </div>

                                            <p class="text-center">
                                                <a class="btn btnshowhide d-block d-lg-none" href="#"
                                                    ><img
                                                        src="/images/svg/showhide.svg"
                                                        alt=""
                                                        class="img-fluid"
                                                        width="9"
                                                /></a>
                                            </p>

                                            <div class="w_box_simulation_result">
                                                <div class="row no-gutters">
                                                    <div class="col-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">毎月のローン返済額</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control monthly-loan-payment"
                                                                    placeholder="155,089"
                                                                />
                                                                <span class="ml-2">円</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">ボーナス分返済金額（年2回）</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="0"
                                                                />
                                                                <span class="ml-2 sub">円/回</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label class="mb-0" for="">管理費</label>
                                                            <h5>{{ estate.management_fee }}<span>万／月</span></h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0" for="">修繕積立金</label>
                                                            <h5>26,000<span>万／月</span></h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-lg-6">
                                                        <!-- <canvas id="myChart" width="213" height="213"></canvas> -->
                                                        <pie-chart-component></pie-chart-component>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="w_box_simulation_result">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">自己資金（頭金）</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    maxlength="4"
                                                                    placeholder="1,000"
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
                                                                    placeholder="5,000"
                                                                />
                                                                <span class="ml-2 sub">万円</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input
                                                        type="text"
                                                        class="js-range-slider"
                                                        name="my_range"
                                                        value=""
                                                        :data-max="estate.total_price"
                                                    />

                                                    <!-- <range-slide-component></range-slide-component> -->
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <label for="">返済期間</label>
                                                            <div class="d-flex align-items-center">
                                                                <input
                                                                    type="text"
                                                                    class="form-control pay-term"
                                                                    placeholder="0"
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
                                                                    type="text"
                                                                    class="form-control interest"
                                                                    placeholder="0"
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

                            <div class="box_renovation_specifications">
                                <h2 class="title">リノベーション仕様</h2>
                                <template v-if="estate.estate_information">
                                    <div
                                        class="specifications_pic"
                                        v-for="photo in estate.estate_information.renovation_media"
                                    >
                                        <img
                                            v-lazy="photo.url_path ? photo.url_path : '/images/no-image.png'"
                                            alt=""
                                            class="img-fluid"
                                        />
                                        <p class="describe">
                                            {{ photo.description }}
                                        </p>
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
                                                管理費：{{ estate.management_fee }}円<br />
                                                修繕積立金：{{ estate.repair_reserve_fee }}円
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
                                                        ? moment(estate.built_date).format('YYYY年MM月')
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
                                <a v-bind:href="'/list'" class="btn btnSeemore">もっと見る</a>
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
        };
    },
    mounted() {
        this.getListEstates();
    },
    methods: {
        getListEstates() {
            const id = this.$route.path.substring(8);
            axios({ url: '/detail', method: 'POST', data: { id: id } }).then(resp => {
                if (resp.data['data'] && resp.data['data']['estate'].length) {
                    this.estate = resp.data['data']['estate'][0];
                    if (this.estate['estate_information']) {
                        if (this.estate['estate_information']['estate_main_photo']) {
                            this.mainPhoto = this.estate['estate_information']['estate_main_photo'];
                        }

                        if (this.estate['estate_information']['renovation_media']) {
                            for (let i = 0; i < this.estate['estate_information']['renovation_media'].length; i++) {
                                this.slider.push(this.estate['estate_information']['renovation_media'][i]['url_path']);
                            }
                        }

                        if (this.estate['estate_information']['estate_befor_photo']) {
                            this.imageBefore = this.estate['estate_information']['estate_befor_photo'];
                        }

                        if (this.estate['estate_information']['estate_after_photo']) {
                            this.imageAfter = this.estate['estate_information']['estate_after_photo'];
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
                    }
                    if (this.estate.latitude && this.estate.longitude) {
                        this.srcMap =
                            'https://www.google.com/maps?q=' +
                            this.estate.latitude +
                            ',' +
                            this.estate.longitude +
                            '&output=embed';
                    }
                }
            });
        },
        change() {
        }
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

        $('.js-range-slider').ionRangeSlider({
            min: 0,
            max: 35,
            from: 10,
            onChange: function(data) {
                console.log(data);
            }
        });

        // var monthlyLoanPayment = $('.monthly-loan-payment');

        var payTerm = $('.js-range-slider1');
        var payTermInput , interestInput;
        payTerm.ionRangeSlider({
            min: 0,
            max: 35,
            postfix: '年'
        });

        payTerm.on('change', function() {
            let input = $(this);
            $('.pay-term').val(input.data('from'));
            payTermInput = input.data('from');

        });

        var interest = $('.js-range-slider2');
        interest.ionRangeSlider({
            min: 0,
            max: 3,
            step: 0.1,
            postfix: '%'
        });

        interest.on('change', function() {
            let input = $(this);
            $('.interest').val(input.data('from'));
            interestInput = input.data('from');
        });
        // console.log(interestInput);
        // console.log(payTermInput);
        // var monthlyPayment = payTermInput * (interestInput / 12) * (1 + (interestInput/12));
        // console.log(monthlyPayment);
        // monthlyLoanPayment.val(monthlyPayment);
    }
};
</script>
