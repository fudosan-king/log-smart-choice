<template>
    <main>
        <div class="box_template">
            <section class="section_near_property bg-white">
                <EstatesComponent></EstatesComponent>
                
            </section>
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
