<template>
	<main>
	    <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">{{ customerName }}へのお知らせ</h2>
                            <!-- <p class="subtitle mb-2">
                                <small>直近2週間のお知らせを新着順に掲載</small>
                            </p> -->
                        </div>
                    </div>
                </section>

                <section class="section_notice">
                    <div class="container">
                        <div class="row">
                            <NoticeComponent></NoticeComponent>
                        </div>
                    </div>
                </section>

            </div>
    </main>
</template>

<script>
    export default {
    	components: {
            NoticeComponent: () => import('../components/NoticeComponent'),
        },
        data() {
            return {
                customerName: '',
            }
        },
        mounted() {
            this.getCustomerName();
        },
        methods: {
            getCustomerName() {
                this.customerName = this.$getCookie('userName');
            }
        },
    };
</script>
