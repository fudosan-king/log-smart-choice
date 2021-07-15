<template>
    <main>
        <div class="box_template">
            <section class="section_new_property">
                <div class="box_top">
                    <div class="container">
                        <EstatesComponent></EstatesComponent>
                    </div>
                </div>
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
