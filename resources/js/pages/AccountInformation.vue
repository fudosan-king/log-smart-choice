<template>
    <main>
        <div>
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-0">会員情報</h2>
                    </div>
                </div>
            </section>

            <section class="section_accinfo bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h4>会員登録情報</h4>
                            <div class="box_accinfo">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-12 align-self-center">
                                        <a href="/customer/update" class="btn btnedit mt-2">変更</a>
                                    </div>
                                    <div class="col-4 col-lg-4 align-self-center">
                                        <p class="head">名前：</p>
                                    </div>
                                    <div class="col-8 col-lg-8 align-self-center">
                                        <p>{{ customerInfo.name }} {{ customerInfo.last_name }}</p>
                                    </div>
                                    <div class="col-4 col-lg-4 align-self-center">
                                        <p class="head">メールアドレス：</p>
                                    </div>
                                    <div class="col-8 col-lg-8 align-self-center">
                                        <p>{{ customerInfo.email ? customerInfo.email : '-/-' }}</p>
                                    </div>
                                    <div class="col-4 col-lg-4 align-self-center">
                                        <p class="head">電話番号：</p>
                                    </div>
                                    <div class="col-8 col-lg-8 align-self-center">
                                        <p>{{ convertPhone(customerInfo.land_line) }}</p>
                                    </div>
                                </div>
                            </div>
                            <h4>メルマガ配信希望条件</h4>
                            <div class="box_accinfo">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-12 align-self-center">
                                        <a href="/customer/announcement-condition" class="btn btnedit mt-2">設定</a>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <p class="head">エリア：</p>
                                    </div>
                                    <div class="col-8 col-lg-8">
                                        <p v-if="customerInfo.first_announcement != 0 && districtList != ''">{{ districtList }}</p>
                                        <p v-else>設定なし</p>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <p class="head">価格：</p>
                                    </div>
                                    <div class="col-8 col-lg-8">
                                        <p>{{ priceTotal }}</p>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <p class="head">広さ：</p>
                                    </div>
                                    <div class="col-8 col-lg-8">
                                        <p>{{ square }}</p>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <p class="head">メール通知設定：</p>
                                    </div>
                                    <div class="col-8 col-lg-8">
                                        <p v-if="customerInfo.send_announcement">メールで通知を受け取る</p>
                                        <p v-else>メールで通知を受け取らない</p>
                                    </div>
                                </div>
                            </div>
                            <h4>パスワード設定</h4>
                            <div class="box_accinfo">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-12 align-self-center">
                                        <a href="/customer/change-password" class="btn btnedit mt-2">設定</a>
                                    </div>
                                    <div class="col-4 col-lg-4 align-self-center">
                                        <p class="head">パスワード：</p>
                                    </div>
                                    <div class="col-8 col-lg-8 align-self-center">
                                        <p>**************</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="top-more-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>サービス一覧</h3>
                            <div class="row">
                                <div class="col-6">
                                    <p>OrderRenoveについて</p>
                                    <p>リノベプラン一覧</p>
                                    <p>マネーシミュレータ</p>
                                    <p>売却サポート</p>
                                </div>
                                <div class="col-6">
                                    <p>物件一覧</p>
                                    <p>OrderRenove通信</p>
                                    <p>コンシェルジュ相談</p>
                                    <p>会員登録</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>エリアから探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>表参道･青山　麻布･広尾　渋谷･恵比寿･中目黒　目黒･白金高輪　下北沢･三軒茶屋　東横線･目黒線　駒沢･二子玉川　代々木公園　井の頭線　神楽坂　品川・田町　銀座・築地　豊洲清澄・門前仲町　皇居西側　中央線　千駄ヶ谷･四ッ谷　西新宿　東新宿･早稲田　その他</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>人気の駅から探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>表参道駅　乃木坂駅　目黒駅　中目黒駅　代官山駅　恵比寿駅　渋谷駅　三軒茶屋駅　広尾駅　麻布十番駅　六本木駅　品川駅　田町駅　五反田駅　大崎駅</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="more-info_item">
                            <h3>こだわりから探す</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>リノベ済物件　カスタム可能物件　ペット飼育可　ウォークインクローゼット　角部屋　眺望・夜景　セキュリティ充実</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>

export default {
    data() {
        return {
            customerInfo: '',
            districtList: '-/-',
            priceTotal: '-/-',
            square: '-/-'
        };
    },
    mounted() {
        this.getCustomerInformation();
    },
    methods: {
        getCustomerInformation() {
            this.$store.dispatch('customerInfo').then(resp => {
                this.customerInfo = resp;
                if (resp.announcement_condition) {
                    let district = resp.announcement_condition.city;
                    let price = resp.announcement_condition.price;
                    let square = resp.announcement_condition.square;
                    if (district === null) {
                        this.districtList = '-/-';
                    } else {
                        let i = 1;
                        let count = district.length;
                        this.districtList = '';
                        district.forEach(element => {
                            if (i != count) {
                                this.districtList += element + ', ';
                            } else {
                                this.districtList += element;
                            }
                            i++;
                        });
                    }

                    if (price === null) {
                        this.priceTotal = '-/-';
                    } else {
                        let min = price.min != '下限なし' ? price.min + '万円' : price.min;
                        let max = price.max != '上限なし' ? price.max + '万円' : price.max;
                        this.priceTotal = min + '~' + max;
                    }

                    if (square === null) {
                        this.square = '-/-';
                    } else {
                        let min = square.min != '下限なし' ? square.min + '㎡' : square.min;
                        let max = square.min != '上限なし' ? square.max + '㎡' : square.max;
                        this.square = min + '~' + max;
                    }
                }
            });
        },
        convertPhone(number) {
            let first, second, third;
            if (number) {
                first = number.slice(0, 3);
                second = number.slice(3, 7);
                third = number.slice(7, 12);
                return first + '-' + second + '-' + third;
            } else {
                return '-';
            }
        }
    }
};
</script>
