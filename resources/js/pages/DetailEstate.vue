<template>
  <main id="main">
    <section class="section_subbanner p-0">
        <div class="w_subbanner_img">
            <img v-bind:src="mainPhoto" alt="" class="img-fluid w-100">
        </div>
    </section>

    <section class="section_expand_room">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="box_expand_room">

                        <div class="box_expand_room_content">
                            <p class="text-center" v-if="estate.custom_field" v-html="estate.custom_field.title"></p>
                            <p class="text-center" v-else>―　Title　―</p>
                            <h2 class="text-center" v-if="estate.custom_field" v-html="estate.custom_field.content"></h2>
                            <h2 class="text-center" v-else>Content</h2>
                            <div class="box_intro">
                                <div class="row">
                                    <div class="col-12 col-lg-5">
                                        <div class="box_intro_left">
                                            <img src="/assets/images/family1.jpg" alt="" class="img-fluid">
                                            <h3>夫婦＋子ども1人</h3>
                                            <ul>
                                                <li>子どもと暮らしやすい間取りにしたい</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-7">
                                        <div class="box_intro_content">
                                            <div class="row no-gutters">
                                                <div class="col-8 col-lg-7">
                                                    <div class="box_intro_content_text">
                                                        <p v-if="estate.custom_field" v-html="estate.custom_field.comment"></p>
                                                        <p v-else>Comment</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-lg-5">
                                                    <img src="/assets/images/waves.png" alt="" class="img-fluid" width="209">
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
                                            <img v-if="estate.estate_information" v-bind:src="estate.estate_information.estate_befor_photo" alt="" class="img-fluid">
                                            <img src="/assets/images/Rectangle 41.png" alt="" class="img-fluid" v-else>

                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="box_beforeafter_img">
                                            <span>After</span>
                                            <img v-if="estate.estate_information" v-bind:src="estate.estate_information.estate_after_photo" alt="" class="img-fluid">
                                            <img src="/assets/images/Rectangle 42.png" alt="" class="img-fluid" v-else>
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
                <div class="carousel-cell" v-for="src, index in slider">
                    <img v-bind:src="src" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="section_expand_room_carousel" v-else>
        <div class="expand_room_carousel">
            <div class="carousel" data-flickity='{ "wrapAround": true, "prevNextButtons": false, "autoPlay": true }'>
                <div class="carousel-cell">
                    <img src="/assets/images/slider/1.png" alt="" class="img-fluid">
                </div>
                <div class="carousel-cell">
                    <img src="/assets/images/slider/2.jpg" alt="" class="img-fluid">
                </div>
                <div class="carousel-cell">
                    <img src="/assets/images/slider/3.jpg" alt="" class="img-fluid">
                </div>
                <div class="carousel-cell">
                    <img src="/assets/images/slider/4.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <div class="w_content bg_sliver">
        <div class="box_smallwindow">
            <h2>オリジナル建具・設備</h2>
            <p class="describe">建具はフローリングと同じく天然無垢材を使用。シンプルで飽きのこないデザインに仕上がります。<br>
            快適に心地よく暮らせる住まいのために、食器洗い乾燥機や浴室暖房乾燥機、温水洗浄付きトイレなど設備にもこだわっています。</p>
            <div class="box_equiment_carousel">
                <div class="carousel carousel-main" data-flickity='{"pageDots": false, "contain": true, "wrapAround": true}'>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/1.png" alt="" class="img-fluid">
                        <p>【キッチン】ホワイトを基調とした清潔感のあるキッチン。使い勝手の良い設備のキッチンで効率よくお料理ができます。</p>
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/2.png" alt="" class="img-fluid">
                        <p>【キッチン】ホワイトを基調とした清潔感のあるキッチン。使い勝手の良い設備のキッチンで効率よくお料理ができます。</p>
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/3.png" alt="" class="img-fluid">
                        <p>【キッチン】ホワイトを基調とした清潔感のあるキッチン。使い勝手の良い設備のキッチンで効率よくお料理ができます。</p>
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/4.png" alt="" class="img-fluid">
                        <p>【キッチン】ホワイトを基調とした清潔感のあるキッチン。使い勝手の良い設備のキッチンで効率よくお料理ができます。</p>
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/5.png" alt="" class="img-fluid">
                        <p>【キッチン】ホワイトを基調とした清潔感のあるキッチン。使い勝手の良い設備のキッチンで効率よくお料理ができます。</p>
                    </div>
                </div>
                <div class="carousel carousel-nav" data-flickity='{ "asNavFor": ".carousel-main", "contain": true, "pageDots": false, "prevNextButtons": false, "wrapAround": true }'>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/1.png" alt="" class="img-fluid">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/2.png" alt="" class="img-fluid">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/3.png" alt="" class="img-fluid">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/4.png" alt="" class="img-fluid">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/equipment/5.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="box_privatelabel">
                <h2>LogRenoveのプライベートレーベル・リノベーション</h2>
                <p class="describe">天然無垢材のフローリングを施した温もりにあふれた暮らしやすい住まい。<br>天然無垢材とは一本の原木から用途やサイズに応じて切り出された角材・板材のこと。<br>
                柔らかな木の肌ざわりと時間の経過と共に魅力が増す暮らしをお楽しみください。</p>
                <div class="box_video">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.riclink.biz/watch?id=742023e0870828cc9e48_37j4by9r&guide=1&share=1"></iframe>
                    </div>
                </div>
            </div>

            <div class="box_flooring">
                <h2>FLOORING</h2>
                <p class="subtitle">選べる無垢材フローリング</p>
                <p class="subtitle2">天然無垢材は樹種によって、色味や木目が異なり、お部屋の仕上がりも大きく印象が変わります。<br>
                本物の木だからこその味わいがお部屋のデザイン性を高めてくれます。</p>
                <ul>
                    <li>
                        <article>
                            <p class="article_thumbnail">
                                <a href="#"><img src="/assets/images/flooring/1.png" alt="" class="img-fluid"></a>
                            </p>
                            <header>
                                <h2><a href="#">オーク材</a></h2>
                                <p>落ち着きのある明るいベージュ色が、さわやかな雰囲気を演出。はっきりとした美しい木目で耐久性にも優れています。</p>
                            </header>
                        </article>
                    </li>
                    <li>
                        <article>
                            <p class="article_thumbnail">
                                <a href="#"><img src="/assets/images/flooring/2.png" alt="" class="img-fluid"></a>
                            </p>
                            <header>
                                <h2><a href="#">樺桜</a></h2>
                                <p>樺桜白くて淡いピンク色の樺桜は清潔感を与え、明るい空間に。無垢材ならではの木の木目や節目、また時とともに移ろう経年変化を楽しめるのも魅力です。</p>
                            </header>
                        </article>
                    </li>
                    <li>
                        <article>
                            <p class="article_thumbnail">
                                <a href="#"><img src="/assets/images/flooring/3.png" alt="" class="img-fluid"></a>
                            </p>
                            <header>
                                <h2><a href="#">ウォルナット</a></h2>
                                <p>ヴィンテージな風合いのダークブラウン色は高級感があり味わい深い室内に。<br>
                                不規則な濃淡の木目は使うほどに味わいがでる人気の樹種です。</p>
                            </header>
                        </article>
                    </li>
                    <li>
                        <article>
                            <p class="article_thumbnail">
                                <a href="#"><img src="/assets/images/flooring/4.png" alt="" class="img-fluid"></a>
                            </p>
                            <header>
                                <h2><a href="#">チーク材</a></h2>
                                <p>濃い黄金色と美しい木目は、経年変化によってより落ち着いた色に深みを増していきます。耐久・耐水性がよく、白アリや害虫に強いというメリットもあります。</p>
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
    export default {
        data() {
            return {
                estate: [],
                mainPhoto: '/assets/images/bg_top.jpg',
                slider: [],
                haveEstate: false
            }
        },
        beforeMount() {
            this.getListEstates();
        },
        methods: {
            getListEstates(){
                // path = '/detail/5ef321e20c9fd67101b8e332'
                const id = this.$route.path.substring(8);
                axios({url: '/detail', method: 'POST', data: {'id': id}})
                    .then(resp => {
                        if (resp.data['data'] && resp.data['data']['estate'].length){
                            this.estate = resp.data['data']['estate'][0];
                            if (this.estate['estate_information']['estate_main_photo']){
                                this.mainPhoto = this.estate['estate_information']['estate_main_photo'];
                                this.noEstate = true;
                            }
                            if (this.estate['estate_information']['renovation_media'].length){
                                for(let i=0; i < this.estate['estate_information']['renovation_media'].length; i++){
                                    this.slider.push(this.estate['estate_information']['renovation_media'][i]['url_path']);
                                }
                            }
                        }
                    })
                    .catch(err => {
                        this.$router.push('/');
                    }
                );
            },
        },
        updated() {
            $('.slider-detail').flickity({
                wrapAround: true,
                prevNextButtons: false,
                autoPlay: true
            });
        }
    };
</script>
