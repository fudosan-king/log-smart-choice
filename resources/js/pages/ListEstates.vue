<template>
    <main>
        <EstatesComponent></EstatesComponent>
    </main>
</template>

<script>
export default {
    components: {
        EstatesComponent: () => import('../components/EstatesComponent')
    },
    metaInfo: {
        titleTemplate: '全物件一覧｜Order Renove'
    }
};
</script>
