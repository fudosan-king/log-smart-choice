<template>
    <main>
        <div class="box_template">
            <section class="section_subbanner pb-0">
                <div class="container">
                    <template v-if="estate.estate_information">
                        <template v-if="estate.estate_information.estate_main_photo[0]">
                            <img
                            v-lazy="estate.estate_information.estate_main_photo[0] ?
                            estate.estate_information.estate_main_photo[0].url_path : '/images/no-image.png'"
                            alt=""
                            class="img-fluid w-100"
                            />
                        </template>
                    </template>
                </div>
            </section>
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <p class="subtitle mb-2">
                            <small v-if="estate.estate_information"><b class="estate_name_title">{{ estate.estate_information.article_title }}</b><br>
                                <template v-if="estate.address"
                                    >{{ estate.address.pref }}{{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}{{ estate.address.gaikutiban }}<br />
                                    専有面積{{ estate.tatemono_menseki }}m²
                                    <template v-if="estate.has_balcony != '無'">
                                        ／バルコニー面積: {{ estate.balcony_space}}m²
                                    </template>
                                    <br />
                                    {{ estate.ground_floors ? estate.ground_floors + '階建' : '' }}／{{ estate.structure }}
                                </template>
                            </small>
                        </p>
                    </div>
                </div>
            </section>

            <section class="p-0 section_carousel">
                <div class="container">
                    <div class="carousel_property">
                        <div class="carousel carousel-main">
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
                        <section class="p-0">
                            <div class="box_top mb-0 title_estate_renovation">
                                <div class="container">
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
                            </div>
                        </section>
                    </div>
                </div>
            </section>

            <section class="section_property_main">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <!-- Start Photos -->

                            <div class="box_renovation_specifications">
                                <template v-if="estate.estate_information">
                                    <div
                                        class="specifications_pic"
                                        v-for="(photo, indexPhoto) in estate.estate_information.renovation_media "
                                    >
                                        <img v-if="photo.url_path != '/images/no-image.png'"
                                            v-lazy="photo.url_path ? photo.url_path : '/images/no-image.png'"
                                            alt=""
                                            class="img-fluid"
                                        />
                                        <template v-if="indexPhoto == 0">
                                            <!-- <h3 class="estate_name_title">{{ estate.estate_name }}</h3>
                                            <p v-if="estate.address"
                                                >{{ estate.address.pref }}{{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}{{ estate.address.gaikutiban }}<br />
                                                専有面積{{ estate.tatemono_menseki }}m²
                                                <template v-if="estate.has_balcony != '無'">
                                                    ／バルコニー面積: {{ estate.balcony_space}}m²
                                                </template>
                                                <br />
                                                {{ estate.ground_floors ? estate.ground_floors + '階建' : '' }}／{{ estate.structure }}
                                            </p> -->
                                        </template>
                                        <template v-else>
                                            <p class="describe" v-html="photo.description"></p>
                                        </template>
                                        
                                    </div>
                                </template>
                                <div class="box_calcu mt-5">
                                    <h1>
                                        <template v-if="estate.renovation_type != 'リノベ済物件'">リノベ＋</template>物件価格
                                        <span>{{ $lscFormatCurrency(estate.price ? estate.price : estate.price) }}</span
                                        >万円
                                    </h1>
                                    <form action="" class="frm_calcu">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <p class="text-center d-none d-lg-block">
                                                    <span class="title_simulation_result">毎月のお支払例</span>
                                                </p>

                                                <div class="box_simulation_result">
                                                    <p class="text-center d-block d-lg-none btn_simulation_result mb-3">毎月のお支払例</p>
                                                    <h2>{{$lscFormatCurrency(paymentMonthly)}}<span>円</span></h2>
                                                    <p class="text-center mt-3">
                                                        <b>管理費：{{ $lscFormatCurrency(estate.management_fee) }}円／修繕積立金：{{ $lscFormatCurrency(estate.repair_reserve_fee) }}円 含む</b>
                                                    </p>
                                                </div>

                                                <p class="text-center box_showmore">
                                                    <a  @click="mobileHandleShow" 
                                                        class="btn btnshowhide d-block d-lg-none"
                                                        :class="{ 'show': mobileShow }"></a>
                                                </p>

                                                <div class="w_box_simulation_result" :class="{'show': mobileShow}">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-6 col-lg-12">
                                                                    <div class="form-group mb-0 mb-lg-3">
                                                                        <label for=""><b>毎月のローン返済額</b></label>
                                                                            <p class="label_repayment_amount">{{ $lscFormatCurrency(monthlyLoan) }}<span><b>円</b></span></p>
                                                                                <input
                                                                                    type="hidden"
                                                                                    class="form-control monthly-loan-payment"
                                                                                    :value="[[$lscFormatCurrency(monthlyLoan)]]"
                                                                                />
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
                                                                </div>
                                                                <div class="col-6 col-lg-12 align-self-end">
                                                                    <div class="form-group">
                                                                        <label class="mb-0" for="">管理費</label>
                                                                        <h5>{{ $lscFormatCurrency(estate.management_fee) }}<span>円／月</span></h5>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="mb-0" for="">修繕積立金</label>
                                                                        <h5>{{$lscFormatCurrency(estate.repair_reserve_fee)}}<span>円／月</span></h5>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <pie-chart-component :parent-data="chartData"></pie-chart-component>
                                                        </div>
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
                                <div class="renovation_specifications_table">
                                    <table class="table">
                                        <tr>
                                            <th width="45%">マンション名</th>
                                            <td>{{ estate.estate_name }}{{ estate.area_bldg_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>住所</th>
                                            <td>
                                                <template v-if="estate.address">
                                                    <div v-if="estate.address.zipcode">〒 {{ estate.address.zipcode }}</div>
                                                    {{ estate.address.pref }}{{ estate.address.city }}{{ estate.address.ooaza }}{{ estate.address.tyoume }}{{ estate.address.gaikutiban }}
                                                </template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>アクセス</th>
                                            <td>
                                                <template v-if="estate.transports">
                                                    <div v-for="transport in estate.transports">
                                                        {{ transport.transport_company }} {{ transport.station_name ? transport.station_name + '駅' : '' }} {{ transport.station_to == 'walk' ? '徒歩' : ''}}{{ transport.walk_mins ? transport.walk_mins + '分' : '' }}
                                                    </div>
                                                </template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>物件価格</th>
                                            <td>{{ $lscFormatCurrency(estate.price) }}万円</td>
                                        </tr>
                                        <tr v-if="estate.management_fee">
                                            <th>管理費</th>
                                            <td>{{ $lscFormatCurrency(estate.management_fee) }}円/月</td>
                                        </tr>
                                        <tr v-if="estate.management_fee && estate.repair_reserve_fee">
                                            <th>修繕積立金</th>
                                            <td>
                                                {{ $lscFormatCurrency(estate.repair_reserve_fee) }}円/月
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>その他費用</th>
                                            <td>
                                                <template v-if="estate.repair_reserve_initial_fee">
                                                    <div>修繕積立基金：{{ estate.repair_reserve_initial_fee }}円</div>
                                                </template>
                                                <template v-if="estate.carpark_fee_min">
                                                    <div>駐車場：{{ $lscFormatCurrency(estate.carpark_fee_min) }}円/{{ estate.carpark_manage_fee.per == 'm' ? '月' : '年' }}</div>
                                                </template>
                                                <template v-if="estate.bike_park_price">
                                                    <div>バイク：{{ $lscFormatCurrency(estate.bike_park_price) }}円/{{ estate.bike_park_price_per == 'm' ? '月' : '年' }}</div>
                                                </template>
                                                <template v-if="estate.bicycles_park_price">
                                                    <div>駐輪場：{{ $lscFormatCurrency(estate.bicycles_park_price) }}円/{{ estate.bicycles_park_price_per == 'm' ? '月' : '年' }}</div>
                                                </template>
                                                <template v-if="estate.homes">
                                                    <template v-if="carParkNote">
                                                        <div v-html="carParkNote"></div>
                                                    </template>
                                                </template>
                                                <template v-if="(estate.usen_fee) || 
                                                (estate.internet_fee) || 
                                                (estate.catv_fee)">
                                                    <template v-if="(estate.usen_fee.initial_cost && estate.usen_fee.repeat_cost.price) ||
                                                        (estate.internet_fee.initial_cost && estate.internet_fee.repeat_cost.price) ||
                                                        (estate.catv_fee.initial_cost && estate.catv_fee.repeat_cost.price)
                                                    ">
                                                        <div>設備費用：
                                                            <ul v-if="estate.usen_fee.initial_cost && estate.usen_fee.repeat_cost.price">
                                                                <li>有線放送：
                                                                    <ul>
                                                                        <li>初期費用: {{ $lscFormatCurrency(estate.usen_fee.initial_cost) }}円</li>
                                                                        <li>定額費用: {{ $lscFormatCurrency(estate.usen_fee.repeat_cost.price) }}円/{{estate.usen_fee.repeat_cost.per == 'm' ? '月' : '年' }}</li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                            <ul v-if="estate.internet_fee.initial_cost && estate.internet_fee.repeat_cost.price">
                                                                <li>インターネット：
                                                                    <ul>
                                                                        <li>初期費用: {{ $lscFormatCurrency(estate.internet_fee.initial_cost) }}円</li>
                                                                        <li>定額費用: {{ $lscFormatCurrency(estate.internet_fee.repeat_cost.price) }}円/{{estate.internet_fee.repeat_cost.per == 'm' ? '月' : '年' }}</li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                            <ul v-if="estate.catv_fee.initial_cost && estate.catv_fee.repeat_cost.price">
                                                                <li>CATV：
                                                                    <ul>
                                                                        <li>初期費用: {{ $lscFormatCurrency(estate.catv_fee.initial_cost) }}円</li>
                                                                        <li>定額費用: {{ $lscFormatCurrency(estate.catv_fee.repeat_cost.price) }}円/{{estate.catv_fee.repeat_cost.per == 'm' ? '月' : '年' }}</li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-if="estate.community_fee_type && estate.community_fee.price">
                                                    <div>
                                                        {{ estate.community_fee_type }}：{{ $lscFormatCurrency(estate.community_fee.price) }}円/<template v-if="estate.community_fee.per == 'm'">月</template><template v-else-if="estate.community_fee.per == 'y'">年</template><template v-else>一括</template>
                                                    </div>
                                                </template>
                                                <template v-if="estate.spa_fee && estate.spa_fee.price">
                                                    <div>
                                                        温泉使用料：{{ $lscFormatCurrency(estate.spa_fee.price) }}円/<template v-if="estate.spa_fee.per == 'm'">月</template><template v-else-if="estate.spa_fee.per == 'y'">年</template><template v-else>一括</template>
                                                    </div>
                                                </template>
                                                <template v-if="otherFee.length > 0">
                                                    <div v-for="fees in otherFee">
                                                        {{ fees.name }} : {{ $lscFormatCurrency(fees.price) }}円/<template v-if="fees.per == 'm'">月</template><template v-else-if="fees.per == 'y'">年</template><template v-else>一括</template>
                                                    </div>
                                                </template>
                                                <template v-if="estate.rights_fee && estate.rights_fee.fee">
                                                    <div>
                                                        権利金：{{ $lscFormatCurrency(estate.rights_fee.fee) }}円
                                                    </div>
                                                </template>
                                                <template v-if="estate.deposit_fee && estate.deposit_fee.fee">
                                                    <div>
                                                        保証金：{{ $lscFormatCurrency(estate.deposit_fee.fee) }}円
                                                    </div>
                                                </template>
                                                <template v-if="estate.guarantee_fee_depreciation">
                                                    <div>
                                                        保証金償却：{{ estate.guarantee_fee_depreciation }}{{ estate.deposit_fee.fee ? estate.deposit_fee.fee : '' }}
                                                    </div>
                                                </template>
                                                <template v-if="estate.guarantee_fee && estate.guarantee_fee.fee">
                                                    <div>
                                                        敷金：{{ $lscFormatCurrency(estate.guarantee_fee.fee) }}円
                                                    </div>
                                                </template>
                                            </td>
                                        </tr>
                                        <tr v-if="estate.tatemono_menseki">
                                            <th>専有面積</th>
                                            <td>{{ estate.tatemono_menseki }}m²</td>
                                        </tr>
                                        <tr v-if="estate.balcony_space">
                                            <th>バルコニー面積</th>
                                            <td>{{ estate.balcony_space }}m²</td>
                                        </tr>
                                        <tr>
                                            <th>間取り</th>
                                            <td>{{ estate.room_count }}{{ estate.room_kind }}<template v-if="estate.service_rooms == 0"></template>
                                            <template v-else-if="estate.service_rooms == 1">+S</template>
                                            <template v-else-if="estate.service_rooms == 2">+SS</template>
                                            <template v-if="estate.service_rooms == 3">+SSS</template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>引渡時期</th>
                                            <td>
                                                <template v-if="estate.delivery">
                                                    <template v-if="estate.delivery.delivery_date_type == '即'">{{ estate.delivery.delivery_date_type }}</template>
                                                    <template v-else-if="estate.delivery.delivery_date_type == '相談'">{{ estate.delivery.delivery_date_type }}</template>
                                                    <template v-else-if="estate.delivery.delivery_date_type == '指定有り'">{{ estate.delivery.delivery_date_type }} {{ moment(estate.delivery.delivery_date).format('YYYY年MM月') }}{{ estate.delivery.delivery_date_about }}</template>
                                                    <template v-else>契約後 {{ estate.delivery.resident_span }} ヶ月</template>
                                                </template>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>入居時期</th>
                                            <td>{{ estateInfo.time_to_join ? estateInfo.time_to_join : '相談' }}</td>
                                        </tr> -->
                                        <tr>
                                            <th>構造</th>
                                            <td>{{ estate.structure ? estate.structure : '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>階建・所在階</th>
                                            <td>
                                                <template v-if="estate.total_houses != 0">
                                                    {{ estate.ground_floors }}階建／{{ estate.room_floor }}階部分
                                                </template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>総戸数</th>
                                            <td>
                                                {{ estate.total_houses }}戸
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>方角</th>
                                            <td>
                                                <template v-if="estate.window_direction == 'n'">北</template>
                                                <template v-if="estate.window_direction == 'ne'">北東</template>
                                                <template v-if="estate.window_direction == 'e'">東</template>
                                                <template v-if="estate.window_direction == 'se'">南東</template>
                                                <template v-if="estate.window_direction == 's'">南</template>
                                                <template v-if="estate.window_direction == 'sw'">南西</template>
                                                <template v-if="estate.window_direction == 'w'">西</template>
                                                <template v-if="estate.window_direction == 'nw'">北西</template>
                                            </td>
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
                                        <!-- <tr>
                                            <th>施工会社</th>
                                            <td>{{ estate.constructor }}</td>
                                        </tr> -->
                                        <tr>
                                            <th>管理会社</th>
                                            <td>
                                                {{ estate.management_company }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>管理形態・管理方式</th>
                                            <td>{{ estate.management_scope }}{{ estate.superintendent ? '／' + estate.superintendent : ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>土地権利</th>
                                            <td>
                                                <template v-if="estate.land_rights == '所有権のみ'">
                                                    <div>{{ estate.land_rights }}</div>
                                                </template>
                                                <template v-else-if="estate.land_rights == '借地権のみ'">
                                                    {{ estate.land_rights_detail }}
                                                    <template v-if="estate.land_leashold_type == '新規'">
                                                        ({{ estate.land_leashold_years }}年 {{ estate.land_leashold_months }}月)
                                                    </template>
                                                    <template v-if="estate.land_leashold_type == '残存'">
                                                        （～{{ estate.land_leashold_type }} {{ moment(parseInt(estate.land_leashold_limit.$date.$numberLong)).format('YYYY年MM月DD日迄') }})
                                                    </template>
                                                    <template v-if="estate.land_fee_type != '無'">
                                                        <div>
                                                            借地料: {{ estate.land_fee }}円/
                                                            <template v-if="estate.land_fee_per == 'm'">月</template>
                                                            <template v-else-if="estate.land_fee_per == 'y'">年</template>
                                                            <template v-else>一括</template>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-else-if="estate.land_rights == '所有権・借地権混在'">
                                                    <div>
                                                        {{ estate.land_rights }}
                                                    </div>
                                                    <div v-if="estate.land_rights_detail">
                                                        借地権種類：{{ estate.land_rights_detail }}
                                                        <template v-if="estate.land_leashold_type == '新規'">
                                                            ({{ estate.land_leashold_years }}年 {{ estate.land_leashold_months }}月)
                                                        </template>
                                                        <template v-if="estate.land_leashold_type == '残存'">
                                                            （～{{ moment(parseInt(estate.land_leashold_limit.$date.$numberLong)).format('YYYY年MM月DD日迄') }})
                                                        </template>
                                                    </div>
                                                    <div v-if="estate.leasehold_ratio">
                                                        借地権割合：{{ estate.leasehold_ratio }}%
                                                    </div>
                                                    <template v-if="estate.land_fee_type != '無'">
                                                        <div>
                                                            地代: {{ estate.land_fee }}円
                                                            <template v-if="estate.land_fee_per == 'm'">/月</template>
                                                            <template v-else-if="estate.land_fee_per == 'y'">/年</template>
                                                            <template v-else>/一括</template>
                                                        </div>
                                                    </template>
                                                </template>
                                                <!-- <template v-if="estate.area_purpose">
                                                    <div>{{ estate.area_purpose.main }}{{ estate.area_purpose.sub }}</div>
                                                </template> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>現況</th>
                                            <td> {{ estate.house_status }} </td>
                                        </tr>
                                        <tr>
                                            <th>国土法</th>
                                            <td>{{ estate.land_law_report }}</td>
                                        </tr>
                                        <tr>
                                            <th>取引態様</th>
                                            <td>{{ estate.trade_type }}</td>
                                        </tr>
                                        <tr>
                                            <th>情報更新日</th>
                                            <td>
                                                {{
                                                     moment(estate.date_last_modified).format('YYYY年MM月DD日')
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>更新予定日</th>
                                            <td>{{ moment().weekday(8).format('YYYY年MM月DD日') }}</td>
                                        </tr>
                                    </table>

                                    <div class="map" v-html="srcMap">
                                        <!-- <iframe
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
                                        ></iframe> -->
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
                            <template v-if="estate.address">
                                <h2 class="title">{{ estate.address.city }}エリアの物件</h2>
                            </template>
                            
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
            chartData: [10, 10, 80],
            totalPrice: 0,
            mobileFirstTime: true,
            carParkNote: '',
            everyMonday: ''
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
        totalPrice: function (newValue, oldValue) {
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
                this.$store
                    .dispatch('getEstate', data)
                    .then((resp) => {
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
                                            price: element.fee.price,
                                            per: element.fee.per
                                        };
                                        this.otherFee.push(data);
                                    }
                                });
                            }
                            this.estateInfo = this.estate['estate_information'];
                            this.borrowedMoney = this.estate.price;
                            this.totalPrice = this.estate.price;
                            this.calculateMonthlyLoanPayment();
                        }
                        this.srcMap = this.estate['estate_information']['url_map'];
                        // if (this.estate.latitude && this.estate.longitude) {
                        //     this.srcMap =
                        //         'https://www.google.com/maps?q=' +
                        //         this.estate.latitude +
                        //         ',' +
                        //         this.estate.longitude +
                        //         '&output=embed';
                        // }
                        let carParkNote = this.estate['homes']['carpark_note'];
                        this.carParkNote = carParkNote.replace(/\n/g, '<br>');
                    })
                    .catch((error) => {});
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
            switch (type) {
                case 'ownMoney':
                    elementClass = '.js-range-slider';
                    break;
                case 'paymentTerm':
                    elementClass = '.js-range-slider1';
                    break;
                case 'paymentInterest':
                    elementClass = '.js-range-slider2';
                    break;
            }
            if (elementClass.length > 0) {
                $(elementClass).data('ionRangeSlider').update({
                    from: from
                });
            }
        },
        changeMoney(type, event) {
            event.preventDefault();
            let currentValue = parseFloat(event.target.value);
            switch (type) {
                case 'lscOwnMoney':
                    if (this.ownMoney == currentValue) {
                        return;
                    }
                    this.ownMoney = currentValue;
                    this.borrowedMoney = this.estate.price - this.ownMoney;
                    this.changeRangeSlider('ownMoney', this.ownMoney);
                    break;
                case 'lscBorrowedMoney':
                    if (this.borrowedMoney == currentValue) {
                        return;
                    }
                    this.borrowedMoney = currentValue;
                    this.ownMoney = this.estate.price - this.borrowedMoney;
                    this.changeRangeSlider('ownMoney', this.ownMoney);
                    break;
                case 'lscPaymentTerm':
                    if (this.paymentTerm == currentValue) {
                        return;
                    }
                    let currentPaymentTerm = currentValue;
                    if (currentPaymentTerm < 0) {
                        this.paymentTerm = 0;
                    } else if (currentPaymentTerm > 35) {
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
                default:
                    break;
            }
            this.calculateMonthlyLoanPayment();
        },
        calculateMonthlyLoanPayment() {
            let interestPercen = this.paymentInterest / 100;
            let paymentTerm12 = this.paymentTerm * 12;
            let interest12 = 1 + interestPercen / 12;
            let interestWithMonth = Math.pow(interest12, paymentTerm12);
            let calBorrowedMoney = this.borrowedMoney * 10000;

            if (this.paymentTerm <= 0) {
                this.monthlyLoan = calBorrowedMoney;
            } else if (this.paymentInterest <= 0) {
                this.monthlyLoan = Math.ceil(calBorrowedMoney / paymentTerm12);
            } else {
                let sharePart = calBorrowedMoney * (interestPercen / 12) * interestWithMonth;
                let dividedPart = interestWithMonth - 1;
                this.monthlyLoan = Math.ceil(sharePart / dividedPart);
            }
            this.paymentMonthly = Math.ceil(
                this.monthlyLoan + this.estate.management_fee + this.estate.repair_reserve_fee
            );
            this.paymentMonthlyBonus = Math.ceil(this.paymentMonthly + this.bonus / 6);
            this.chartData = [this.estate.management_fee, this.estate.repair_reserve_fee, this.monthlyLoan];
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
            contain: true,
            pageDots: false,
            initialIndex: 1
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
