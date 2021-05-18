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
export default {
    components: {
        headerBar: () => import('./templates/Header'),
        footerBar: () => import('./templates/Footer')
    }
};
</script>
