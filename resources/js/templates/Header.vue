<template>
    <header>
        <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-sticky-slide">
            <a class="navbar-brand" v-bind:href="'/'"
                ><img v-bind:src="iconLogo" alt="" class="img-fluid" width="200"
            /></a>
            <button class="navbar-toggler toggler-spring">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-end">
                <ul class="navbar-nav navbar-mobile mr-0">
                    <li class="nav-item">
                        <a class="nav-link active" v-bind:href="'/'">物件＋リノベーション</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">リノベーションプラン集</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-bind:href="'/login'"
                            ><img v-bind:src="iconUser" alt="" class="img-fluid" width="16" /> ログイン</a
                        >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tel:000-0000-0000"
                            >000-0000-0000
                            <span>年中無休8:00〜18:30</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">オンライン問い合わせ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="spacing"></div>
    </header>
</template>
<script>
export default {
    data() {
        const iconLogo = '/design/images/SVG/logo.svg';
        const iconUser = '/design/images/SVG/i_user.svg';
        return {
            iconLogo: iconLogo,
            iconUser: iconUser
        };
    }
};
</script>
