<template>
    <main>
        <div class="box_template">
            <EstatesComponent></EstatesComponent>
        </div>
    </main>
</template>

<script>
export default {
    components: {
        EstatesComponent: () => import('../components/EstatesComponent')
    }
};
</script>
