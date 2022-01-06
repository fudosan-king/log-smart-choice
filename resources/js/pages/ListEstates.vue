<template>
    <main>
        <EstatesComponent></EstatesComponent>
    </main>
</template>

<script>
export default {
    components: {
        EstatesComponent: () => import('../components/EstatesComponent')
    }
};
</script>
