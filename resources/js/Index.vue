<template>
    <div id="page">
        <headerBar></headerBar>
        <div id="main">
            <router-view></router-view>
        </div>
        <footerBar></footerBar>
    </div>
</template>
<script>
import headerBar from './templates/Header';
import footerBar from './templates/Footer';
export default {
    data() {
        return {
            //
        };
    },
    components: {
        headerBar,
        footerBar
    }
};
</script>
