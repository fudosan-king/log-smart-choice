<template>
    <main id="main">
        <section class="section_subbanner p-0">
            <div class="w_subbanner_img">
                <img v-lazy="mainPhoto" alt="" class="img-fluid w-100" />
            </div>
        </section>

        <section class="section_topinfo estate_info">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="w_box_topinfo">
                            <div class="box_topinfo">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-3 align-self-center">
                                        <div class="box_topinfo_img">
                                            <img v-lazy="`/assets/images/building.jpg`" alt="" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 align-self-center">
                                        <div class="row no-gutters">
                                            <div class="col-12 col-lg-8 align-self-center">
                                                <div class="box_topinfo_content">
                                                    <h2>
                                                        {{ estate.estate_name }}
                                                    </h2>
                                                    <div class="row">
                                                        <div class="col-6 prices">
                                                            <template v-if="estate.tatemono_menseki">
                                                                {{ estate.tatemono_menseki }} ㎡
                                                            </template>
                                                        </div>
                                                        <div class="col-6 prices">
                                                            <template v-if="estate.price">
                                                                {{ estate.price }} <span class="number">万</span
                                                                ><span class="yen">円</span>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <tr span="col-3">
                                    <th>住所</th>
                                    <td class="td-info-estate">東京都世田谷区池尻2-35-9</td>
                                    <th>現況</th>
                                    <td v-if="estate.house_status">{{ estate.house_status }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>アクセス</th>
                                    <td>
                                        <div v-for="(transports, index) in estate.transports">
                                            <template v-if="transports.bus_company">
                                                {{ transports.bus_company }}
                                            </template>
                                            <template v-if="transports.bus_station">
                                                「{{ transports.bus_station }}」バス停
                                            </template>
                                            <template v-if="transports.bus_walk_mins">
                                                {{ transports.bus_walk_mins }}分<br />
                                            </template>
                                            <template v-if="transports.car_distance">
                                                {{ transports.car_distance }}バス停
                                            </template>
                                            <template v-if="transports.car_mins">
                                                「{{ transports.car_mins }}分<br />
                                            </template>
                                            <template v-if="transports.transport_company">
                                                {{ transports.transport_company }}
                                            </template>
                                            <template v-if="transports.station_name">
                                                「{{ transports.station_name }}」駅徒歩
                                            </template>
                                            <template v-if="transports.walk_mins">
                                                {{ transports.walk_mins }}分<br />
                                            </template>
                                        </div>
                                    </td>
                                    <th>引渡</th>
                                    <td v-if="estate.delivery">{{ estate.delivery.delivery_date_type }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>間取り</th>
                                    <td v-if="estate.room_count && estate.room_kind">
                                        {{ estate.room_count }} {{ estate.room_kind }}
                                    </td>
                                    <td v-else></td>
                                    <th>管理会社</th>
                                    <td v-if="estate.management_company">{{ estate.management_company }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>広さ</th>
                                    <td v-if="estate.tatemono_menseki">{{ estate.tatemono_menseki }} ㎡</td>
                                    <td v-else></td>
                                    <th>管理方式</th>
                                    <td v-if="estate.management_scope">{{ estate.management_scope }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>バルコニー</th>
                                    <td v-if="estate.balcony_space">{{ estate.balcony_space }}㎡</td>
                                    <td v-else></td>
                                    <th>土地権利</th>
                                    <td v-if="estate.land_rights">{{ estate.land_rights }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>構造</th>
                                    <td v-if="estate.structure">{{ estate.structure }}</td>
                                    <td v-else></td>
                                    <th>階層</th>
                                    <td v-if="estate.room_floor">{{ estate.room_floor }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>取引態様</th>
                                    <td v-if="estate.trade_type">{{ estate.trade_type }}</td>
                                    <td v-else></td>
                                    <th>総戸数</th>
                                    <td v-if="estate.total_houses">{{ estate.total_houses }}</td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>情報更新日</th>
                                    <td v-if="estate.date_last_modified">
                                        {{ moment(estate.date_last_modified).format('YYYY/MM/DD') }}
                                    </td>
                                    <td v-else></td>
                                    <th>築年月</th>
                                    <td v-if="estate.built_date">
                                        {{ moment(estate.built_date).format('YYYY年MM月') }}
                                    </td>
                                    <td v-else></td>
                                </tr>
                                <tr>
                                    <th>改装年月</th>
                                    <td v-if="estate.renovation_done_date">
                                        {{ moment(estate.renovation_done_date).format('YYYY年MM月') }}
                                    </td>
                                    <td v-else>ー</td>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_expand_room">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="box_expand_room">
                            <div class="box_expand_room_content">
                                <p
                                    class="text-center"
                                    v-if="estate.custom_field"
                                    v-html="estate.custom_field.title"
                                ></p>
                                <p class="text-center" v-else>―　Title　―</p>
                                <h2
                                    class="text-center"
                                    v-if="estate.custom_field"
                                    v-html="estate.custom_field.content"
                                ></h2>
                                <h2 class="text-center" v-else>Content</h2>
                                <div class="box_intro">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="box_intro_left">
                                                <img
                                                    v-if="estate.custom_field"
                                                    v-lazy="estate.custom_field.description_url_image_left"
                                                    alt=""
                                                    class="img-fluid"
                                                />
                                                <img v-else v-lazy="`/assets/images/family1.png`" alt="" class="img-fluid" />
                                                <h3
                                                    v-if="estate.custom_field"
                                                    v-html="estate.custom_field.description_title"
                                                ></h3>
                                                <h3 v-else>Description title</h3>
                                                <ul v-if="estate.custom_field" class="estate-description-content">
                                                    <pre id="pre-description">
                                                    <li v-html="estate.custom_field.description_content"></li>
                                                </pre>
                                                </ul>
                                                <ul v-else>
                                                    <li>Description content</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7">
                                            <div class="box_intro_content">
                                                <div class="row no-gutters">
                                                    <div class="col-8 col-lg-7">
                                                        <div class="box_intro_content_text">
                                                            <p v-if="estate.custom_field">
                                                                {{
                                                                    estate.custom_field.comment
                                                                        .replace(/\n/g, '\\n')
                                                                        .replace(/\r/g, '\\r')
                                                                        .replace(/\t/g, '\\t')
                                                                }}
                                                            </p>
                                                            <p v-else>Comment</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-lg-5">
                                                        <img
                                                            v-if="estate.custom_field"
                                                            v-lazy="estate.custom_field.description_url_image_right"
                                                            alt=""
                                                            class="img-fluid"
                                                        />
                                                        <img
                                                            v-else
                                                            v-lazy="`/assets/images/waves.png`"
                                                            alt=""
                                                            class="img-fluid"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_beforeafter">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-lg-6">
                                            <div class="box_beforeafter_img">
                                                <span>Before</span>
                                                <img
                                                    v-if="estate.estate_information.estate_befor_photo"
                                                    v-lazy="estate.estate_information.estate_befor_photo"
                                                    alt=""
                                                    class="img-fluid"
                                                />
                                                <img
                                                    v-lazy="`/assets/images/Rectangle 41.png`"
                                                    alt=""
                                                    class="img-fluid"
                                                    v-else
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-lg-6">
                                            <div class="box_beforeafter_img">
                                                <span>After</span>
                                                <img
                                                    v-if="estate.estate_information.estate_after_photo"
                                                    v-lazy="estate.estate_information.estate_after_photo"
                                                    alt=""
                                                    class="img-fluid"
                                                />
                                                <img
                                                    v-lazy="`/assets/images/Rectangle 42.png`"
                                                    alt=""
                                                    class="img-fluid"
                                                    v-else
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_expand_room_carousel" v-if="slider.length">
            <div class="expand_room_carousel">
                <div class="carousel slider-detail">
                    <div class="carousel-cell" v-for="(src, index) in slider">
                        <img v-lazy="src" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>
        <section class="section_expand_room_carousel" v-else>
            <div class="expand_room_carousel">
                <div
                    class="carousel slider-detail"
                    data-flickity='{ "wrapAround": true, "prevNextButtons": false, "autoPlay": true }'
                >
                    <div class="carousel-cell">
                        <img v-lazy="`/assets/images/slider/1.png`" alt="" class="img-fluid" />
                    </div>
                    <div class="carousel-cell">
                        <img v-lazy="`/assets/images/slider/2.jpg`" alt="" class="img-fluid" />
                    </div>
                    <div class="carousel-cell">
                        <img v-lazy="`/assets/images/slider/3.jpg`" alt="" class="img-fluid" />
                    </div>
                    <div class="carousel-cell">
                        <img v-lazy="`/assets/images/slider/4.jpg`" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>

        <div class="w_content bg_sliver">
            <div class="box_smallwindow">
                <h2>オリジナル建具・設備</h2>
                <p class="describe">
                    建具はフローリングと同じく天然無垢材を使用。シンプルで飽きのこないデザインに仕上がります。<br />
                    快適に心地よく暮らせる住まいのために、食器洗い乾燥機や浴室暖房乾燥機、温水洗浄付きトイレなど設備にもこだわっています。
                </p>
                <div class="box_equiment_carousel">
                    <div class="carousel carousel-main">
                        <div
                            class="carousel-cell"
                            v-for="slide in estateInfo.estate_equipment"
                            :key="slide.slide_equipment"
                        >
                            <img :src="slide.slide_equipment" alt="" class="img-fluid" />
                            <p>{{ slide.caption_equipment }}</p>
                        </div>
                    </div>
                    <div class="carousel carousel-nav">
                        <div
                            class="carousel-cell"
                            v-for="slide in estateInfo.estate_equipment"
                            :key="slide.slide_equipment"
                        >
                            <img v-lazy="slide.slide_equipment" alt="" class="img-fluid" />
                        </div>
                    </div>
                </div>

                <div class="box_privatelabel">
                    <h2>LogRenoveのプライベートレーベル・リノベーション</h2>
                    <p class="describe">
                        天然無垢材のフローリングを施した温もりにあふれた暮らしやすい住まい。<br />天然無垢材とは一本の原木から用途やサイズに応じて切り出された角材・板材のこと。<br />
                        柔らかな木の肌ざわりと時間の経過と共に魅力が増す暮らしをお楽しみください。
                    </p>
                    <div class="box_video">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe
                                class="embed-responsive-item"
                                src="https://player.riclink.biz/watch?id=742023e0870828cc9e48_37j4by9r&guide=1&share=1"
                            ></iframe>
                        </div>
                    </div>
                </div>

                <div class="box_flooring">
                    <h2>FLOORING</h2>
                    <p class="subtitle">選べる無垢材フローリング</p>
                    <p class="subtitle2">
                        天然無垢材は樹種によって、色味や木目が異なり、お部屋の仕上がりも大きく印象が変わります。<br />
                        本物の木だからこその味わいがお部屋のデザイン性を高めてくれます。
                    </p>
                    <ul>
                        <li v-for="estateImage in estateInfo.estate_flooring" :key="estateImage.flooring_image_url">
                            <article>
                                <p class="article_thumbnail">
                                    <a href="#"
                                        ><img v-lazy="estateImage.flooring_image_url" alt="" class="img-fluid"
                                    /></a>
                                </p>
                                <header>
                                    <h2>
                                        <a href="#" class="font-japanese">{{ estateImage.flooring_title }}</a>
                                    </h2>
                                    <p>{{ estateImage.flooring_content }}</p>
                                </header>
                            </article>
                        </li>
                    </ul>
                </div>
            </div>
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
    data() {
        return {
            estate: [],
            mainPhoto: '/assets/images/bg_top.jpg',
            slider: [],
            haveEstate: false,
            moment,
            estateInfo: []
        };
    },
    beforeMount() {
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
                            this.noEstate = true;
                        }

                        if (this.estate['estate_information']['renovation_media']) {
                            for (let i = 0; i < this.estate['estate_information']['renovation_media'].length; i++) {
                                this.slider.push(this.estate['estate_information']['renovation_media'][i]['url_path']);
                            }
                        }
                        this.estateInfo = this.estate['estate_information'];
                    }
                }
            });
        }
    },
    updated() {
        $('.slider-detail').flickity({
            wrapAround: true,
            prevNextButtons: false,
            autoPlay: true
        });
        $('.carousel-main').flickity({
            pageDots: false,
            contain: true,
            wrapAround: true
        });
        $('.carousel-nav').flickity({
            asNavFor: '.carousel-main',
            contain: true,
            pageDots: false,
            prevNextButtons: false,
            wrapAround: true
        });
    }
};
</script>
