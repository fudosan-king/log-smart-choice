<template>
    <main id="main">
        <section class="section_topbanner">
            <div class="topbanner_content">
                <p><img v-lazy="`/assets/images/SVG/text_banner.svg`" alt="" class="img-fluid" width="335"></p>
                <p><img v-lazy="`/assets/images/SVG/logo_orderrenove.svg`" alt="" class="img-fluid" width="453"></p>
                <p>オーダーリノベ</p>
                <p class="mb-0">『自分に合った住まい』を考え、新しい暮らしの夢を膨らませませんか？<br>
                自宅にいながら最適なリノベーションを全力でサポートいたします。</p>
            </div>
        </section>

        <section class="section_propertyinformation">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <EstatesTopComponent></EstatesTopComponent>
                        <p class="text-center mb-0"><a href="/list" class="btn btnBlack">もっと物件を見る</a></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_showroom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="box_showroom">
                            <div class="row no-gutters">
                                <div class="col-12 col-lg-6">
                                    <div class="box_showroom_img">
                                        <img v-lazy="`/assets/images/showroom.png`" alt="" class="img-fluid w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="box_showroom_content">
                                        <h2>SHOWROOM</h2>
                                        <p class="sub_title">ショールーム個別相談</p>
                                        <p>リノベーションにはどのような方法があるのか、自分にはどんなリノベーションがあっているのかなど、リノベーショ
                                        ンに関する質問・疑問にお答えします。無垢材を使用したショールームで、皆様のライフスタイルや今後のライフプラ
                                        ンに合わせて、私たちが最適なリノベーションを全力でサポートさせていただきます。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-center mb-0"><a href="https://www.logrenove.jp/events/21534/" class="btn btnBlack" target="_blank">詳細を見る</a></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_seminar">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <article>
                            <p class="article_thumbnail"><a href="https://www.logrenove.jp/events/26102/" target="_blank"><img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/12/IMG_7385-3.jpg`" alt="" class="img-fluid"></a></p>
                            <header>
                                <!-- <p class="article_meta">
                                    <a href="https://www.logrenove.jp/events/tags/omotesando/" target="_blank">表参道ショールーム</a>
                                    <a href="https://www.logrenove.jp/events/tags/online/" target="_blank">オンライン</a>
                                    <a href="https://www.logrenove.jp/events/tags/virtual-planner/" target="_blank">バーチャルプランナー</a>
                                </p> -->
                                <h2><a href="https://www.logrenove.jp/events/26102/" target="_blank">リノベーション向き物件の探し方｜リノベーション会社だから知っているポイント</a></h2>
                                <p class="article_summary">
                                リノベーションに向いている物件探しのお悩みにお答えします!「なかなかいい物件に出会えなくて困っている...」という方も多
                                いです。リノベーション会社ならではの中古物件の見つけ方、リノベーションのポイントを学び、理想の住まいの実現に生かしま
                                せんか?
                                </p>
                            </header>
                        </article>
                        <article>
                            <p class="article_thumbnail"><a href="https://www.logrenove.jp/events/16976/" target="_blank"><img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/11/20200208-013-1.jpg`" alt="" class="img-fluid"></a></p>
                            <header>
                                <!-- <p class="article_meta">
                                </p> -->
                                <h2><a href="https://www.logrenove.jp/events/16976/" target="_blank">「築浅」or「築古＋リノベ」？中古物件購入＋リノベーション講座｜知っておきたい基礎知識とは？</a></h2>
                                <p class="article_summary">
                                中古マンションを買ってリノベーションする際に知っておきたい基礎知識講座です。中古物件を探し際に確認しておきたいことか
                                ら、資産価値や資金計画など様々なお悩み事を解決してみませんか?
                                </p>
                            </header>
                        </article>
                        <article>
                            <p class="article_thumbnail"><a href="https://www.logrenove.jp/events/24217/" target="_blank"><img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/11/MG_8605-880x460-1-1.jpg`" alt="" class="img-fluid"></a></p>
                            <header>
                                <!-- <p class="article_meta">
                                    <a href="https://www.logrenove.jp/events/tags/omotesando/" target="_blank">表参道ショールーム</a>
                                    <a href="https://www.logrenove.jp/events/tags/online/" target="_blank">オンライン</a>
                                    <a href="https://www.logrenove.jp/events/tags/virtual-planner/" target="_blank">バーチャルプランナー</a>
                                </p> -->
                                <h2><a href="https://www.logrenove.jp/events/24217/" target="_blank">中古物件の価格相場とリノベーション費用｜資金に関する基礎講座</a></h2>
                                <p class="article_summary">
                                物件購入とリノベーション費用について解説する基礎講座。トータルでかかる費用を把握して、予算内で理想の住まいを実現へ!
                                リノベーション費用の内訳、予算の決め方、ローンの組み方、物件の探し方について疑問を解決しませんか?
                                </p>
                            </header>
                        </article>
                        <p class="text-center mb-0"><a href="https://www.logrenove.jp/events/" class="btn btnBlack" target="_blank">他のセミナーを見る</a></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section_construction">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="construction_header">
                            <div class="row">
                                <div class="col-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 align-self-center">
                                            <h2>施工事例コラム</h2>
                                        </div>
                                        <div class="col-12 col-lg-8 align-self-center">
                                            <p class="mb-0">LogRenoveならではの無垢材を使ったリノベーション事例をご覧いただけます</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 text-right">
                                    <a href="https://www.logrenove.jp/work/" class="btn btn_seeall" target="_blank">施工事例をすべて見る <img v-lazy="`/assets/images/SVG/i_right.svg`" alt="" class="img-fluid" width="7"></a>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <article>
                                    <p class="article_thumbnail">
                                        <a href="https://www.logrenove.jp/work/471/" target="_blank">
                                            <img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/05/neko.jpg`" alt="" class="img-fluid">
                                        </a>
                                    </p>
                                    <h3><a href="https://www.logrenove.jp/work/471/" target="_blank">オーナーの「猫愛」が止まらない…猫が縦横無尽に遊ぶ家</a></h3>
                                    <!-- <p><span>すべては猫のために…愛猫家のリノベーションは発想が違う</span></p> -->
                                </article>
                            </li>
                            <li>
                                <article>
                                    <p class="article_thumbnail">
                                        <a href="https://www.logrenove.jp/work/569/" target="_blank">
                                            <img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/03/takayamatei-800x534.jpg`" alt="" class="img-fluid">
                                        </a>
                                    </p>
                                    <h3><a href="https://www.logrenove.jp/work/569/" target="_blank">リビング内書斎、回遊できるキッチンが「夫婦円満」の秘訣!?</a></h3>
                                    <!-- <p><span>別の部屋にいても、お互いの存在を何となく感じられる間取り</span></p> -->
                                </article>
                            </li>
                            <li>
                                <article>
                                    <p class="article_thumbnail">
                                        <a href="https://www.logrenove.jp/work/655/" target="_blank">
                                            <img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/03/1000%E7%B9%9D%E4%BB%A3%CE%A6%E7%B9%9D%C2%80-800x534.jpg`" alt="" class="img-fluid">
                                        </a>
                                    </p>
                                    <h3><a href="https://www.logrenove.jp/work/655/" target="_blank">こだわったのは無垢材と陽ざしの温もり。子供とともに“成長”する家</a></h3>
                                    <!-- <p><span>子どもと同じ。手がかかるけど可愛い!?</span></p> -->
                                </article>
                            </li>
                            <li>
                                <article>
                                    <p class="article_thumbnail">
                                        <a href="https://www.logrenove.jp/work/808/" target="_blank">
                                            <img v-lazy="`https://www.logrenove.jp/wp-content/uploads/2020/04/I-sama-main-800x522.jpg`" alt="" class="img-fluid">
                                        </a>
                                    </p>
                                    <h3><a href="https://www.logrenove.jp/work/808/" target="_blank">暮らし方、時間の流れさえも変えた「無垢材リノベ」との出会い</a></h3>
                                    <!-- <p><span>「好きなように部屋を変えられる」ならとことんやりたい</span></p> -->
                                </article>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
<script>
    import EstatesTopComponent from '../components/EstatesTopComponent';
    import Lazyload from 'vue-lazyload';
    import Vue from 'vue';

    Vue.use(Lazyload, {
        preLoad: 1.3,
        error: 'images/no-image.png',
        loading: 'images/loading.gif',
        attempt: 1,
    });
    export default {
        components: {
            EstatesTopComponent,
        },
    };
</script>
