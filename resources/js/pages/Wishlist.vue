<template>
	<main>
	    <div class="box_template">
                <section class="section_new_property pt-0">
                    <div class="box_top">
                        <div class="container">
                            <h2 class="title mb-3">お気に入り物件一覧</h2>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <CustomerWishlistComponent></CustomerWishlistComponent>
                        </div>
                    </div>
                </section>
            </div>
    </main>
</template>

<script>
    export default {
    	components: {
            CustomerWishlistComponent: () => import('../components/CustomerWishlistComponent'),
        },
    };
</script>
