<template>
    <footer>
        <div class="footer_top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <p class="text-center mb-4">
                            <a class="logo_footer" href="https://order-renove.jp/"
                                ><img
                                    src="/assets/images/svg/logo_orderrenove_white.svg"
                                    alt=""
                                    class="img-fluid"
                                    width="224"
                            /></a>
                        </p>
                        <ul class="d-none d-lg-flex">
                            <li><a target="_blank" href="https://form.run/@order-renove">お問い合わせ</a></li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/privacypolicy"
                                    >プライバシーポリシー</a
                                >
                            </li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/socialpolicy"
                                    >ソーシャルメディアポリシー</a
                                >
                            </li>
                            <li><a target="_blank" href="https://www.propolife.co.jp/terms"> 利用規約</a></li>
                            <li><a target="_blank" href="https://www.propolife.co.jp">運営会社（企業情報）</a></li>
                            <li>
                                <a target="_blank" href="https://www.propolife.co.jp/antisocial"
                                    >反社会的勢力排除に関する基本方針</a
                                >
                            </li>
                        </ul>
                        <div class="d-flex">
                            <ul class="d-block d-lg-none mr-5">
                                <li><a target="_blank" href="https://form.run/@order-renove">お問い合わせ</a></li>
                                <li>
                                    <a target="_blank" href="https://www.propolife.co.jp/privacypolicy"
                                        >プライバシーポリシー</a
                                    >
                                </li>
                                <li>
                                    <a target="_blank" href="https://www.propolife.co.jp/socialpolicy"
                                        >ソーシャルメディアポリシー</a
                                    >
                                </li>
                            </ul>
                            <ul class="d-block d-lg-none">
                                <li><a target="_blank" href="https://www.propolife.co.jp/terms"> 利用規約</a></li>
                                <li><a target="_blank" href="https://www.propolife.co.jp">運営会社（企業情報）</a></li>
                                <li>
                                    <a target="_blank" href="https://www.propolife.co.jp/antisocial"
                                        >反社会的勢力排除に関する基本方針</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <hr />

                        <p class="text-center">
                            <a target="_blank" href="https://www.logrenove.jp/"
                                ><img
                                    src="/assets/images/svg/logrenove_logo_copy.svg"
                                    alt=""
                                    class="img-fluid"
                                    width="108"
                            /></a>
                        </p>
                        <ul>
                            <li>
                                <a target="_blank" href="https://www.logsuite.co.jp"
                                    ><img
                                        src="/assets/images/svg/logSuite2_white.svg"
                                        alt=""
                                        class="img-fluid"
                                        width="88"
                                /></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.logarchitects.co.jp"
                                    ><img
                                        src="/assets/images/svg/logArch2_white.svg"
                                        alt=""
                                        class="img-fluid"
                                        width="120"
                                /></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.logknot.co.jp"
                                    ><img
                                        src="/assets/images/svg/logKnot2_white.svg"
                                        alt=""
                                        class="img-fluid"
                                        width="84"
                                /></a>
                            </li>
                        </ul>
                        <p class="text-center">
                            <small
                                >Copyright © <a target="_blank" href="https://www.logsuite.co.jp">LogSuite.</a> All
                                Rights Reserved.</small
                            >
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom fixed-bottom" v-if="contactPart == 'detail'">
            <a class="btn" href="javascript:void(0)" v-on:click="directToContact"
                ><img src="/assets/images/svg/i_mail.svg" alt="" class="img-fluid" width="18" />お問い合わせ</a
            >
            <a class="btn" href="tel:0368978564"
                ><img src="/assets/images/svg/i_call.svg" alt="" class="img-fluid" width="18" />03-6897-8564</a
            >
        </div>
        <div class="footer_bottom fixed-bottom align-center" v-if="routeName == 'home' || routeName == 'list' || routeName == 'listByCode'">
            <a class="btn" href="javascript:void(0)" v-on:click="floatButtonEvent"
                >希望条件を入力</a
            >
        </div>
        <div
            class="modal fade modal_register"
            id="modal_register"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            いつもOrderRenoveをご覧頂き<br />
                            ありがとうございます。<br />
                            お申し込みには「会員登録」が必要です。
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li>
                                <a class="btn" href="javascript:void(0)" @click="facebookLogin"
                                    ><img
                                        src="/assets/images/svg/i_fb.svg"
                                        alt=""
                                        class="img-fluid"
                                        width="24"
                                    />Facebookではじめる</a
                                >
                            </li>
                            <li>
                                <a class="btn" href="javascript:void(0)" @click="googleLogin"
                                    ><img src="/assets/images/svg/i_google.svg" alt="" class="img-fluid" width="24" />
                                    Googleではじめる</a
                                >
                            </li>
                        </ul>
                        <p class="termofuse mt-3">
                            <a href="https://www.propolife.co.jp/terms">利用規約</a>・
                            <a href="https://www.propolife.co.jp/privacypolicy">プライバシーポリシー</a>
                            に同意の上、<br />会員登録を行ってください。
                        </p>
                        <p class="mb-0">または</p>
                        <p class="mb-0">
                            <a href="/register" class="btn btn-lg btn_register">メールアドレスで登録</a>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <p class="text-center">
                            <a href="/login">すでに会員の方はログイン</a>
                        </p>
                        <p class="text-center">
                            <a href="javascript:void(0)" @click="contactWithOutLogin">ログインせずに自分入力</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
<script>
import ScrollTopArrow from '../components/ScrollTopComponent';

export default {
    components: {
        ScrollTopArrow
    },
    data() {
        const logoSliver = '/assets/images/SVG/logo_sliver.svg';
        const iLocationBlack = '/assets/images/SVG/i_location_black.svg';
        return {
            logoSliver: logoSliver,
            iLocationBlack: iLocationBlack,
            contactPart: '',
        };
    },
    mounted() {
        this.showContactPart();
    },
    methods: {
        showContactPart() {
            let urlContact = window.location.pathname.split('/');
            this.contactPart = urlContact[1];
        },
        directToContact() {
            if (this.$getCookie('accessToken').length) {
                let currentUrl = this.$route.path.split('/');
                let routeContact = this.$router.resolve({ name: 'contact' }).href;
                this.$setCookie('estate_id', currentUrl[2], 1);
                window.open(window.location.origin + routeContact, '_blank');
            } else {
                $('#modal_register').modal('toggle');
            }
        },

        googleLogin() {
            this.$store.dispatch('googleLogin').then(response => {
                window.location.href = '/';
            });
        },

        facebookLogin() {
            const store = this.$store;
            FB.login(
                function(response) {
                    if (response.authResponse) {
                        store.dispatch('facebookLogin').then(response => {
                            window.location.href = '/';
                        });
                    }
                },
                { scope: 'public_profile, email' }
            );
            return false;
        },

        contactWithOutLogin() {
            let currentUrl = this.$route.path.split('/');
            let routeContact = this.$router.resolve({ name: 'contact' }).href;
            this.$setCookie('estate_id', currentUrl[2], 1);
            window.open(window.location.origin + routeContact, '_blank');
        },

        floatButtonEvent() {
            let accessToken = this.$getCookie('accessToken');
            if (accessToken.length > 0) {
                this.$router.push({ name: 'announcementCondition' }).catch(() => {});
            } else {
                this.$router.push({ name: 'login' }).catch(() => {});
            }
        }
    },
    computed: {
        routeName () {
            return this.$route.name;
        }
    }
};
</script>
