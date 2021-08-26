<template>
    <main>
        <headerBar></headerBar>
        <router-view></router-view>
        <footerBar></footerBar>
    </main>
</template>
<script>
export default {
    components: {
        headerBar: () => import('./templates/Header'),
        footerBar: () => import('./templates/Footer')
    }
};
</script>
