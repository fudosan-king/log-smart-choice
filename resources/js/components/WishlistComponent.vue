<template>
    <!-- <template v-if="checkItem == 1"> -->
    <a href="javascript:void(0);" class="btn_wishlist" @click="onClick" :class="{ on: isActive }"></a>
    <!-- </template>
    <template  v-else> -->
    <!-- <a href="javascript:void(0);" class="btn_wishlist" @click="onClick" :class="{on: isActive}"></a> -->
    <!-- </template> -->
</template>

<script>
export default {
    name: 'WishlistComponent',
    props: ['estateId', 'dataWished'],
    data() {
        let isActive = false;
        if (typeof this.dataWished != 'undefined') {
            isActive = true;
        }

        return {
            isActive : isActive,
            estates: [],
        };
    },
    methods: {
        onClick() {
            this.isActive = !this.isActive;
            // let isWish = this.isActive ? 1 : 0;
            let accessToken = this.$getCookie('accessToken');
            if (accessToken != '') {
                let data = {
                    estateId: this.estateId,
                    is_wish: this.isActive,
                    accessToken: accessToken
                };
                this.$store.dispatch('addWishList', data, accessToken);
            }
        },
    }
};
</script>

<style scoped>
.active {
    display: none;
}
</style>
