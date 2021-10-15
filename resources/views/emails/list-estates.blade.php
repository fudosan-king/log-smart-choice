<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>【株式会社プロスタイルからのお知らせ】</title>

    <style type="text/css">
        * {
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
        }

        body {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
            /* font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif !important; */
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: #382f2e;
        }

        .tableContent img {
            border: 0 !important;
            display: block !important;
            outline: none !important;
        }

        a {
            color: #382f2e;
            text-decoration: none;
        }

        p,
        h2 {
            color: #382f2e;
            margin: 0;
        }

        div,
        p,
        ul,
        h2 {
            margin: 0;
        }

        h2 {
            font-size: 21px;
            font-weight: normal;
            color: #000;
        }

        h3 {
            color: #000;
            font-weight: bold;
        }

        p {
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
            color: #333333;
        }

        .box_pro {
            padding: 15px;
        }

        .btn {
            font-size: 14px;
            color: #fff;
            padding: 10px 15px;
            background: #F39A7B;
            display: block;
            text-align: center;
            margin: 15px auto 0;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }

        .price span {
            font-size: 12px;
            font-weight: normal;
        }

        @media (max-width: 768px) {
            table {
                width: 100% !important;
            }
        }

        @media only screen and (max-width:480px) {
            table {
                width: 100%;
            }
        }

        @media only screen and (max-width:540px) {
            table {
                width: 100%;
            }
        }
    </style>

</head>

<body paddingwidth="0" paddingheight="0" bgcolor="#fff" style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" class="tableContent" style="font-family:Georgia, times, sans-serif;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; padding: 20px 15px; text-align: center;">
                        <tr>
                            <td>
                                <a style="text-align: center; display: block; border-bottom: 1px solid #BDBDBD; padding-bottom: 15px;" target="_blank" href="{{Request::root()}}"><img style="margin: auto;" src="https://propolife.s3.ap-northeast-1.amazonaws.com/logo.png" alt="" width="350"></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align: right; color: #828282; margin-top: 15px;">
                                    {{ date('Y年m月d日') }}
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 660px; margin: auto; margin-top: 20px;">
                        <tr>
                            <td style="text-align: center;">
                                <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 17px;">本日のオススメ物件</h2>
                                <p>ご希望の条件を選択して頂くと、お客様にぴったりの物件情報をメールでお届けします。</p>
                            </td>
                        </tr>
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 660px; margin: 30px auto 20px;">
                        <tr>
                            <td style="text-align: center; padding: 20px 20px; background: #F2F2F2;">
                                <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">{{ $customer['name'] }}様の希望条件</h2>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: left; margin-bottom: 15px;">
                                    <tr>
                                        <th valign="top" width="20%">希望エリア</th>
                                        @if ($customer['first_announcement'] != 1)
                                        <td>設定なし</td>
                                        @else
                                        <td>{{ $condition['city'] }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>価格</th>
                                        <td>
                                            @if ($condition['price']['min'] == '下限なし')
                                            {{ $condition['price']['min'] }} ~
                                            @else
                                            {{ $condition['price']['min'] }}万円 ~
                                            @endif
                                            @if ($condition['price']['max'] == '上限なし')
                                            {{ $condition['price']['max'] }}
                                            @else
                                            {{ $condition['price']['max'] }}万円
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>広さ</th>
                                        <td>
                                            @if ($condition['square']['min'] == '下限なし')
                                            {{ $condition['square']['min'] }} ~
                                            @else
                                            {{ $condition['square']['min'] }}㎡ ~
                                            @endif
                                            @if ($condition['square']['max'] == '上限なし')
                                            {{ $condition['square']['max'] }}
                                            @else
                                            {{ $condition['square']['max'] }}㎡
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <a href="{{Request::root()}}/customer/announcement-condition" style="border-radius: 100px; background: #E0AF6C; font-weight: 600; font-size: 18px; padding: 10px 15px; color: #fff; display: inline-block; min-width: 256px;">希望条件の登録・変更</a>
                                <p style="font-size: 12px; margin-top: 15px;">「<a href="{{Request::root()}}/customer/information"><span style="color: #E0AF6C;">マイページ</span></a>」にログイン後、「<a href="{{Request::root()}}/customer/announcement-condition"><span style="color: #E0AF6C;">メルマガ配信希望条件</span></a>」から希望条件をお選びください。</p>
                            </td>
                        </tr>
                    </table>


                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 660px; margin: auto;">
                        @foreach ($data as $estate)
                        <tr>
                            <td style="border: 1px solid #BDBDBD; padding-bottom: 20px; text-align: center;">
                                <a href="{{Request::root()}}/detail/{{$estate['_id']}}">
                                    @if ($estate['estate_information']['estate_main_photo'])
                                    <img src="{{ Request::root() }}{{$estate['estate_information']['estate_main_photo'][0]['url_path'] }}" alt="" style="width: 100%;">
                                    @else
                                    <img src="{{ Request::root() }}/images/no-image.png" alt="" style="width: 100%;">
                                    @endif
                                </a>
                                <h3 style="text-align: center; font-size: 24px; font-weight: 600; margin-bottom: 15px; margin-top: 20px; color: #333333;">{{$estate['estate_information']['article_title']}}</h3>
                                <p><a style="text-decoration: none; color: #333; cursor: inherit;" href="#">{{ $estate['address']['pref'] }}{{ $estate['address']['city'] }}{{ $estate['address']['ooaza'] }}{{ $estate['address']['tyoume'] }}{{ $estate['address']['gaikutiban'] }}</a>{{'／'. $estate['transports'][0]['station_name'] .'駅' }}</p>
                                <p>{{ $estate['room_count'] }}{{ $estate['room_kind'] }}/{{ $estate['tatemono_menseki'] }}m²/{{ $estate['price'] + $estate['renovation_cost'] }}万円</p>
                                <a href="{{Request::root()}}/detail/{{$estate['_id']}}" style="border-radius: 100px; background: #E0AF6C; font-weight: 600; font-size: 18px; padding: 10px 85px; color: #fff; display: inline-block; margin-top: 15px;">物件詳細を見る</a>
                            </td>
                        </tr>

                        <tr>
                            <td style="margin-bottom: 20px;">&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td style="padding: 30px 0; text-align: center;">
                                <a href="{{Request::root()}}/list" style="color: #EB5757; text-decoration: underline; font-size: 18px;">すべての物件を見る</a>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 2px solid #BDBDBD; padding: 20px; text-align: center; border-radius: 10px;">
                                <h2 style="font-size: 14px; font-weight: 600; border-bottom: 2px solid #BDBDBD; padding-bottom: 15px; margin-bottom: 20px;">{{ $customer['name'] }}様の希望条件</h2>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: left; margin-bottom: 15px;">
                                    <tr>
                                    <th valign="top" width="20%">希望エリア</th>
                                        @if ($customer['first_announcement'] != 1)
                                        <td>設定なし</td>
                                        @else
                                        <td>{{ $condition['city'] }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>価格</th>
                                        <td>
                                            @if ($condition['price']['min'] == '下限なし')
                                            {{ $condition['price']['min'] }} ~
                                            @else
                                            {{ $condition['price']['min'] }}万円 ~
                                            @endif
                                            @if ($condition['price']['max'] == '上限なし')
                                            {{ $condition['price']['max'] }}
                                            @else
                                            {{ $condition['price']['max'] }}万円
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>広さ</th>
                                        <td>
                                            @if ($condition['square']['min'] == '下限なし')
                                            {{ $condition['square']['min'] }} ~
                                            @else
                                            {{ $condition['square']['min'] }}㎡ ~
                                            @endif
                                            @if ($condition['square']['max'] == '上限なし')
                                            {{ $condition['square']['max'] }}
                                            @else
                                            {{ $condition['square']['max'] }}㎡
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <a href="{{Request::root()}}/customer/announcement-condition" style="border-radius: 100px; background: #E0AF6C; font-weight: 600; font-size: 18px; padding: 10px 85px; color: #fff; display: inline-block;">希望条件の登録・変更</a>
                                <p style="font-size: 12px; margin-top: 15px;">「<a href="{{Request::root()}}/customer/information"><span style="color: #E0AF6C;">マイページ</span></a>」にログイン後、「<a href="{{Request::root()}}/customer/announcement-condition"><span style="color: #E0AF6C;">メルマガ配信希望条件</span></a>」から希望条件をお選びください。</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="margin-bottom: 20px; text-align: center; padding: 30px 0 0;">
                                <a style="font-size: 10px; color: #EB5757; text-decoration: underline;" href="#">メールの配信停止をご希望のかたはこちら</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p style="text-align: center; margin-top: 10px; font-size: 10px;">メールの配信停止をご希望の方はこちら<br>
                                    ログイン後「メルマガ配信希望条件」から「メール通知設定」のチェックを外してください</p>
                            </td>
                        </tr>
                    </table>

                    <!-- <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 660px; margin: 30px auto 20px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <h2 style="padding: 15px;">新着物件</h2>
                            </td>
                        </tr>
                        @foreach ($data as $estate)
                        <tr>
                            <td>
                                <div class="box_pro">
                                    <a href="{{Request::root()}}/detail/{{$estate['_id']}}">
                                        @if ($estate['estate_information']['estate_main_photo'])
                                        <img src="{{ Request::root() }}{{$estate['estate_information']['estate_main_photo'][0]['url_path'] }}" alt="" style="width: 100%;">
                                        @else
                                        <img src="{{ Request::root() }}/images/no-image.png" alt="" style="width: 100%;">
                                        @endif
                                    </a>
                                    <h3 style="text-align: center; font-size: 18px; color: #4F4F4F;">{{$estate['estate_name']}}</h3>
                                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tr>
                                            <td width="60%">
                                                <p>{{ $estate['address']['city'] }}{{ $estate['address']['ooaza'] }}{{ $estate['address']['tyoume'] }}</p>
                                                <p>{{ $estate['tatemono_menseki'] }}m²（{{ $estate['room_count'] }}{{ $estate['room_kind'] }}+DEN）</p>
                                            </td>
                                            <td width="40%">
                                                @if($estate['price'])
                                                <p class="price">{{ $estate['price'] }}<span>万円</span></p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2" style="padding-right: 15%; padding-left: 15%">

                                            </td>
                                            <td style="padding-right: 5%;">
                                                <a class="btn" style="color: #fff;" href="{{Request::root()}}/detail/{{$estate['_id']}}">3Dを見る</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <a class="btn" href="{{Request::root()}}/detail/{{$estate['_id']}}" style="color: #fff; margin: 15px 30px 0;">物件詳細を見る</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table> -->

                    <!-- <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: 20px auto;">
                        <tr>
                            <td style="text-align: center;">
                                <h2 style="padding: 10px; font-size: 14px;">{{ $customer['name'] }}様の希望条件</h2>
                            </td>
                        </tr>
                    </table> -->

                    <!-- <table border="0" bgcolor="#fff" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; text-align: left; padding: 15px 15px;">
                        <tr>
                            <th width="30%">希望エリア</th>
                            @if ($customer['first_announcement'] != 1)
                            <td>設定なし</td>
                            @else
                            <td>{{ $condition['city'] }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>価格</th>
                            <td>
                                @if ($condition['price']['min'] == '下限なし')
                                {{ $condition['price']['min'] }} ~
                                @else
                                {{ $condition['price']['min'] }}万円 ~
                                @endif
                                @if ($condition['price']['max'] == '上限なし')
                                {{ $condition['price']['max'] }}
                                @else
                                {{ $condition['price']['max'] }}万円
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>広さ</th>
                            <td>
                                @if ($condition['square']['min'] == '下限なし')
                                {{ $condition['square']['min'] }} ~
                                @else
                                {{ $condition['square']['min'] }}㎡ ~
                                @endif
                                @if ($condition['square']['max'] == '上限なし')
                                {{ $condition['square']['max'] }}
                                @else
                                {{ $condition['square']['max'] }}㎡
                                @endif
                            </td>
                        </tr>
                    </table> -->

                    <!-- <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: 20px auto;">
                        <tr>
                            <td style="text-align: center;">
                                <p style="padding: 10px; font-size: 12px;">希望条件の変更について: <a style="color: #EB5757;" href="https://order-renove.jp/customer/information ">「マイページ」</a>にログイン後、<br>
                                    <a style="color: #EB5757;" href="https://order-renove.jp/customer/announcement-condition">「 メルマガ配信希望条件」</a>からご希望条件のお選びください。
                                </p>
                            </td>
                        </tr>
                    </table> -->

                    <!-- <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; text-align: left;">
                        <tr>
                            <td style="text-align: center; padding: 10px 0 30px;">
                                <p style="text-decoration: underline;"><a style="color: #EB5757;" href="{{Request::root()}}/customer/information">メールの配信停止をご希望の方はこちら</a></p>
                                <p style="font-size: 11px;">ログイン後、「メルマガ配信希望条件」から、</p>
                                <p style="font-size: 11px;">「メールで通知を受け取る」のチェックを外してください。</p>
                            </td>
                        </tr>
                    </table> -->

                    <div class="footer" style="background: #2C4057; padding: 30px 0 20px; text-align: center; margin-top: 30px; ">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 660px; margin: auto; text-align: left;">
                            <tr>
                                <td style="text-align: center;">
                                    <p style="padding-bottom: 20px; text-align: center;"><a target="_blank" href="{{Request::root()}}"><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/logo_white.png" alt="" width="150" style="margin: auto;"></a></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align: center; color: #fff; font-size:10px;">Copyright © <a style="color: #fff;" target="_blank" href="https://www.logsuite.co.jp/logmansion/contact">LogSuite.</a> All Rights Reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>



</body>

</html>