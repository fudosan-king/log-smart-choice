<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> -->
<!doctype html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>【株式会社プロスタイルからのお知らせ】</title>

    <style type="text/css">
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
            font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif !important;
            font-size: 13px;
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

        p {}

        .box_pro {
            padding: 15px;
        }

        .btn {
            font-size: 14px;
            color: #fff;
            padding: 10px 15px;
            background: #EB5757;
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

<body paddingwidth="0" paddingheight="0" bgcolor="#F2F2F2" style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">


    <table align="center" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0" class="tableContent" style="font-family:Georgia, times, sans-serif;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; padding: 20px 15px; text-align: center;">
                        <tr>
                            <td>
                                <a target="_blank" href="https://order-renove.jp/"><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/logo.png" alt="" width="150"></a>
                            </td>
                            <td>
                                <p>{{ date('Y年m月d日') }}</p>
                            </td>
                        </tr>
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; padding: 15px;">
                        <tr>
                            <td style="text-align: center;">
                                <p>※※{{ $customer['name'] }}様の希望にマッチした物件が<br>
                                    新規公開されました。</p>
                            </td>
                        </tr>
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto;">
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
                                    <img src="{{ 'https://order-renove.jp'.$estate['estate_information']['estate_main_photo'][0]['url_path'] }}" alt="" style="width: 100%;">
                                </a>
                                    <h3 style="text-align: center; font-size: 18px; color: #4F4F4F;">{{$estate['estate_name']}}</h3>
                                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tr>
                                            <td style="padding-left: 45px;">
                                                <p>{{ $estate['address']['city'] }}{{ $estate['address']['ooaza'] }}{{ $estate['address']['tyoume'] }}</p>
                                                <p>{{ $estate['tatemono_menseki'] }}m²（{{ $estate['room_count'] }}{{ $estate['room_kind'] }}+DEN）</p>
                                            </td>
                                            <td style="padding-right: 45px;">
                                                @if($estate['total_price'])
                                                <p class="price">{{ $estate['total_price'] }}<span>万円</span></p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%" style="padding-left: 5%;">
                                                <a class="btn" href="{{Request::root()}}/detail/{{$estate['_id']}}" style="margin-right: 15px; color: #fff;">物件詳細を見る</a>
                                            </td>
                                            <td style="padding-right: 5%;">
                                                <a class="btn" style="color: #fff;" href="{{Request::root()}}/detail/{{$estate['_id']}}">3Dを見る</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: 20px auto;">
                        <tr>
                            <td style="text-align: center;">
                                <h2 style="padding: 10px; font-size: 14px;">{{ $customer['name'] }}様の希望の希望条件</h2>
                            </td>
                        </tr>
                    </table>

                    <table border="0" bgcolor="#fff" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; text-align: left; padding: 15px 15px;">
                        <tr>
                            <th width="20%">希望エリア</th>
                            <td>{{ $condition['city'] }}</td>
                        </tr>
                        <tr>
                            <th>価格</th>
                            <td>{{ $condition['square']['min'] }} ~ {{ $condition['square']['max'] }}</td>
                        </tr>
                        <tr>
                            <th>広さ</th>
                            <td>{{ $condition['price']['min'] }} ~ {{ $condition['price']['max'] }}</td>
                        </tr>
                        <tr>
                            <th>こだわり</th>
                            <td>設定なし</td>
                        </tr>
                    </table>

                    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: 20px auto;">
                        <tr>
                            <td style="text-align: center;">
                                <p style="padding: 10px; font-size: 14px;">希望条件の変更について: <a style="color: #EB5757;" href="https://order-renove.jp/customer/information ">「マイページ」</a>にログイン後、<br>
                                    <a style="color: #EB5757;" href="https://order-renove.jp/customer/announcement-condition">「 メルマガ配信希望条件」</a>からご希望条件のお選びください。
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; text-align: left;">
                        <tr>
                            <td style="text-align: center; text-decoration: underline; padding: 10px 0 30px;">
                                <p><a style="color: #EB5757;" href="https://order-renove.jp/customer/information">メールの配信停止をご希望のかたはこちら</a></p>
                            </td>
                        </tr>
                    </table>

                    <div class="footer" style="background: #000; padding: 30px 0; text-align: center; ">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 800px; margin: auto; text-align: left;">
                            <tr>
                                <td style="text-align: center;">
                                    <p style="padding-bottom: 30px; border-bottom: 1px solid #828282; text-align: center;"><a target="_blank" href="https://order-renove.jp/"><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/logo_white.png" alt="" width="150" style="margin: auto;"></a></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; padding: 30px 0;">
                                    <a style="display: inline-block; margin-right: 25px;" href="#" title=""><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/i_ins.png" alt="" width="18"></a>
                                    <a style="display: inline-block; margin-right: 25px;" href="#" title=""><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/i_twitter.png" alt="" width="18"></a>
                                    <a style="display: inline-block;" href="#" title=""><img src="https://propolife.s3.ap-northeast-1.amazonaws.com/i_fb.png" alt="" width="18"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align: center; color: #828282;">Copyright © <a style="color: #828282;" target="_blank" href="https://www.logsuite.co.jp/logmansion/contact">LogSuite.</a> All Rights Reserved.</p>
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