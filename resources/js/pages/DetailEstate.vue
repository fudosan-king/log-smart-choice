<template>
  <main id="main">
    <section class="section_topbanner" v-bind:style="styleObject">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section>
    <section class="section_expand_room">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="box_expand_room">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item" v-for="src, index in slider" v-bind:class="{ 'active': index === 0 }">
                                    <img class="d-block w-100" v-bind:src="src" alt="">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <div class="box_expand_room_content" v-if="estate.custom_field">
                            <p class="text-center">― {{ estate.custom_field.title }} ―</p>
                            <h2 class="text-center">{{ estate.custom_field.content }}</h2>
                            <div class="box_intro">
                                <div class="row">
                                    <div class="col-12 col-lg-5">
                                        <div class="box_intro_left">
                                            <img src="/design/images/family.png" alt="" class="img-fluid">
                                            <h3>夫婦・子ども2人</h3>
                                            <p>● 子どもがのびのびと遊べる空間を持ちたい<br>
                                            ● 家族4人の荷物がしっかり収納できるスペースがほしい<br>
                                            ● 夫婦が好きな本を飾れるスペースを設けたい</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-7">
                                        <div class="box_intro_content">
                                            <div class="row no-gutters">
                                                <div class="col-8 col-lg-7">
                                                    <div class="box_intro_content_text">
                                                        <p>{{ estate.custom_field.comment }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-lg-5">
                                                    <img src="/design/images/wave.png" alt="" class="img-fluid" width="180">
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
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="box_beforeafter_img">
                                            <span>After</span>
                                            <img v-if="estate.estate_information" v-bind:src="estate.estate_information.estate_after_photo" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w_content">
                        <div class="box_smallwindow">
                            <h2>キッチンからリビングが見える小窓</h2>
                            <img src="/design/images/Rectangle 55.jpg" alt="" class="img-fluid">
                            <p class="describe">キッチンの壁にはリビングの様子がわかる小窓を設置。料理をしながら、今日の学校でのできごとやお友達のことなどを聞くことができます。<br>
                            子どもが出かけている時には、ゆっくりテレビを見ながら家事を進めることもできるのも魅力。壁をあえて残すことで、コンロからの臭いや油飛びを防いでいます。</p>
                        </div>

                        <div class="box_wardrobe">
                            <h2>家族全員の荷物がまとまるウォークインクローゼット</h2>
                            <img src="/design/images/Rectangle 55.png" alt="" class="img-fluid">
                            <p class="describe">寝室にはたっぷり収納できるウォークインクローゼットを設け、家族4人の荷物をたっぷり収納できるようにしました。家族全員の衣類を一か所にまとめることで、洗濯物の片付けの手間をカット。<br>
                            少しでも団らんの時間を増やせるといいですね。</p>
                        </div>

                        <div class="box_bookshelf">
                            <h2>お気に入りの本をディスプレイ</h2>
                            <img src="/design/images/Rectangle 56.jpg" alt="" class="img-fluid w-100">
                            <p class="describe mb-0">夫婦のお気に入りの本を飾れるディスプレイ棚を設置。溝を深めにしてあるので、本が倒れにくくなっています。<br>
                            雑誌や絵本、旅の思い出のポストカードを飾ってもいいですね。</p>
                        </div>

                        <div class="box_example">
                            <div class="row no-gutters">
                                <div class="col-4 col-lg-2">
                                    <img src="/design/images/wave2.png" alt="" class="img-fluid" width="174">
                                </div>
                                <div class="col-8 col-lg-10">
                                    <div class="box_example_content">
                                        <p>例えば同じお部屋をリノベーションするとしても、家族構成や、ペットの有無、ご家族の趣味、生活スタイルなどによって、暮らしやすいお部屋は違います。<br>
                                        ご家族みんなが過ごしやすく、心地よい生活ができるお家作りをご提案させていただきます。<br>
                                        はじめてお話する時には、まだ具体的なプランが決まっていない方がほとんどです。<br>
                                        まずは、こんなことがしたい！というご希望をお聞かせください。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </main>
</template>

<script>
    export default {
        data() {
            return {
                estate: [],
                styleObject: {
                    'background': 'url("/design/images/bg_top.jpg") no-repeat center',
                    'background-size': 'cover'
                },
                slider: []
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
                                this.styleObject = {
                                    'background-size': 'cover',
                                    'background-image': 'url(' + this.estate['estate_information']['estate_main_photo'] + ')',
                                    'ackground-repeat': 'no-repeat',
                                    'background-position': 'center'
                                }
                            }
                            if (this.estate['estate_information']['renovation_media'].length){
                                for(let i=0; i < this.estate['estate_information']['renovation_media'].length; i++){
                                    this.slider.push(this.estate['estate_information']['renovation_media'][i]['url_path']);
                                }
                            }
                        } else {
                            this.$router.push('/');
                        }
                    })
                    .catch(err => {
                        this.$router.push('/');
                    }
                );
            },
        }
    };
</script>
