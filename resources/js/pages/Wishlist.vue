<template>
    <main>
        <div class="bg-white">
            <section class="section_new_property pt-0 pb-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">お気に入り</h2>
                    </div>
                </div>
            </section>
            <section class="bg-white pt-0">
                <CustomerWishlistComponent></CustomerWishlistComponent>
                
            </section>
        </div>
    </main>
</template>

<script>
export default {
    components: {
        CustomerWishlistComponent: () => import('../components/CustomerWishlistComponent')
    }
};
</script>
