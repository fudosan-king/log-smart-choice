<template>
    <main>
        <EstatesComponent @title-dynamic="updateTitle"></EstatesComponent>
    </main>
</template>

<script>
export default {
    data() {
        let titleDynamic = '';
        return {
            titleDynamic: titleDynamic
        }
    },
    components: {
        EstatesComponent: () => import('../components/EstatesComponent')
    },
    metaInfo() {
        let titleTemplate = this.titleDynamic + ' リノベーションマンション一覧｜OrderRenove';
        return {
            titleTemplate: titleTemplate
        }
    },
    methods: {
        updateTitle(keyword) {
            this.titleDynamic = keyword;
        }
    },
};
</script>
