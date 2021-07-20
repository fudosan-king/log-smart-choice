<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title> Email template </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Abril+Fatface" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        body {
            font-family: Abril Fatface !important;
            font-style: normal;
            font-weight: normal;
            align-items: center;
            text-align: center;
        }

        .datetime {
            width: 470px;
            height: 26px;
            left: 148px;
            top: 60px;
            font-size: 16px;
            line-height: 22px;
            display: inline-flex;
            color: #000000;
            padding-bottom:10px
        }

        .logo_orderrenove_black {
            margin: 16px auto!important;
            width: 246px;
            height: 33px;
            left: 84px;
            top: 16px;
        }

        .text-content {
            padding-top: 22px;
            font-size: 18px;
            line-height: 133.7%;
        }

        .arrival,
        .condition {
            font-size: 22px;
            line-height: 30px;
            padding: 16px 0;
        }

        .line {
            border: 1px solid #0095B6;
            width: 5rem;
            margin: 15px 10px;
        }

        .condition .line {
            border: 1px solid #0095B6;
            width: 3rem;
            margin: 15px 10px;
        }

        .image-estate img {
            width: 30rem;
            height: 20rem;
            left: 47px;
            top: 586px;
        }

        button {
            flex-direction: row;
            padding: 10px 0px;
            width: 78px;
            left: calc(50% - 78px/2 + 47px);
            color: #fff;
            background: #EB5757;
            border: 1px solid #EB5757;
            box-sizing: border-box;
            border-radius: 4px;
            font-size: 14px;
            margin: 0 11px;
        }

        .social i {
            width: 32px;
            height: 32px;
            margin: 0 7px;
        }

        .information {
            font-size: 12px;
        }
    </style>

<body class="main-body app sidebar-mini" style="font-family: Abril Fatface !important; font-style: normal; font-weight: normal; align-items: center; text-align: center; width:480px; margin-left:auto; margin-right:auto; padding-top:12px; border:1px solid grey">


<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="sortable">
            <div class="row row-sm">
                <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- <div class="logo_orderrenove_black">
                        <img src="https://order-renove.jp/assets/images/SVG/logo_orderrenove_black.svg" alt="">
                    </div> -->
                    <div class="datetime">
                        <img width="120px" height="80px" src="https://fdk-production.s3-ap-northeast-1.amazonaws.com/2c/502a5e94b8956e122300022c/50312538efb7160d43753ea2.jpeg" alt="">
                        <p style="margin-left:50%; margin-top:0%;">{{date('Y年m月d日')}}</p>
                    </div>
                    <div class="sub-title" style="font-size: 14px; border-top:1px solid grey; padding-top:10px;">
                            <div>※※**様の希望にマッチした物件が</div>
                            <div>新規公開されました。</div>
                    </div>
                    <div class="arrival">
                        <div class="row justify-content-center">
                            <p class="">新規到着物件</p>
                        </div>
                    </div>
                    @if ($data)
                        @foreach ($data as $key => $estate)
                            <div class="estates pt-4">
                                <div class="image-estate" style="position:relative; max-height:310px; overflow:hidden; max-width:450px; padding:10px">
                                    <!-- @if ($estate->estate_information)
                                        <img src="{{env('APP_URL')}}{{ $estate->estate_information->estate_main_photo }}" alt="estate{{$key}}" title="estate{{$key}}" width="30rem" height="20rem" >
                                    @endif -->
                                    <img style="padding-bottom:7px;" src="https://fdk-production.s3-ap-northeast-1.amazonaws.com/2c/502a5e94b8956e122300022c/50312538efb7160d43753ea2.jpeg">
                                    
                                </div>
                                <div style="border:1px solid grey; padding-bottom: 1.5rem; margin-left:10px; width:458px;">
                                    <div class="content-estate p-4">
                                        <p class="m-0">{{ $estate->estate_name }}</p>
                                        <p class="m-0">{{ $estate->address['pref'] }}{{ $estate->address['city'] }}{{ $estate->address['ooaza'] }}{{ $estate->address['tyoume'] }}</p>
                                        <p class="m-0">{{ $estate->tatemono_menseki }}㎡ ({{ $estate->room_count }}{{ $estate->room_kind }})</p>
                                    </div>
                                    <div class="button">
                                        <button style="width: 25%; border-radius:0">詳細を見る</button>
                                        <button style="width: 25%; border-radius:0">3Dを見る</button>
                                    </div>
                                </div>
                                
                            </div>
                            <p></p>
                        @endforeach
                    @endif
                    <!-- <div class="estates pt-4">
                        <div class="image-estate">
                            <img src="https://order-renove.jp/estates/5ed879f90c9fd60e6a7d96de/main_photo/20210201_084623_main_photo.jpg" alt="">
                        </div>
                        <div class="content-estate p-4">
                            <p class="m-0">麻布狸穴ナショナルコート</p>
                            <p class="m-0">東京メトロ千代田線「表参道」歩3分</p>
                            <p class="m-0">48.24 ㎡ 1LDK+DEN 5,400万円</p>
                        </div>
                        <div class="button">
                            <button>詳細を見る</button>
                            <button>3Dを見る</button>
                        </div>
                    </div>
                    <div class="estates pt-4">
                        <div class="image-estate">
                            <img src="https://order-renove.jp/estates/5ed879f90c9fd60e6a7d96de/main_photo/20210201_084623_main_photo.jpg" alt="">
                        </div>
                        <div class="content-estate p-4">
                            <p class="m-0">麻布狸穴ナショナルコート</p>
                            <p class="m-0">東京メトロ千代田線「表参道」歩3分</p>
                            <p class="m-0">48.24 ㎡ 1LDK+DEN 5,400万円</p>
                        </div>
                        <div class="button">
                            <button>詳細を見る</button>
                            <button>3Dを見る</button>
                        </div>
                    </div>
                    <div class="estates pt-4">
                        <div class="image-estate">
                            <img src="https://order-renove.jp/estates/5ed879f90c9fd60e6a7d96de/main_photo/20210201_084623_main_photo.jpg" alt="">
                        </div>
                        <div class="content-estate p-4">
                            <p class="m-0">麻布狸穴ナショナルコート</p>
                            <p class="m-0">東京メトロ千代田線「表参道」歩3分</p>
                            <p class="m-0">48.24 ㎡ 1LDK+DEN 5,400万円</p>
                        </div>
                        <div class="button">
                            <button>詳細を見る</button>
                            <button>3Dを見る</button>
                        </div>
                    </div>
                    <div class="estates pt-4">
                        <div class="image-estate">
                            <img src="https://order-renove.jp/estates/5ed879f90c9fd60e6a7d96de/main_photo/20210201_084623_main_photo.jpg" alt="">
                        </div>
                        <div class="content-estate p-4">
                            <p class="m-0">麻布狸穴ナショナルコート</p>
                            <p class="m-0">東京メトロ千代田線「表参道」歩3分</p>
                            <p class="m-0">48.24 ㎡ 1LDK+DEN 5,400万円</p>
                        </div>
                        <div class="button">
                            <button>詳細を見る</button>
                            <button>3Dを見る</button>
                        </div>
                    </div> -->
                    <div class="condition pt-4">
                        <div class="row justify-content-center">
                            <p class="">※※**様の希望条件
                            </p>
                        </div>
                    </div>
                    <div class="description">
                        <p class="address">**区、**区、**区</p>
                        <p class="square">****平米以上</p>
                        <p class="total-price">****万円</p>
                    </div>
                    <div class="contact m-auto">
                        <div>
                            <p>希望条件の変更について: 「
                                <a href="#" class="mypage" style="color:red"> マイページ</a>」にログイン後、
                            </p>
                        </div>
                        <div>「<a href="#" class="setting-mail" style="color:red">メルマガ配信希望条件</a>」からご希望条件のお選びください。</p></div>
                    </div>
                    <div class="social">
                        <a href=""><img src="facebook.png" alt=""></a>
                        <a href=""><img src="line.png" alt=""></i>
                        </a>
                        <a href=""><img src="twitter.png" alt=""></i>
                        </a>
                        <a href=""><img src="instagram.png" alt=""></a>
                    </div>
                    <div class="information font-12 mb-5 mt-3">
                        <p class="m-0"><b>Website: https//www.order-Renove.jp</b></p>
                        <p><b>Copyright © LogSuite Inc. All Rights Reserved.</b></p>
                    </div>
                </div>


            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- Container closed -->
</div>
<!-- main-content closed -->
</body>


</html>