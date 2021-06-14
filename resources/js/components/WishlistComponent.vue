<template>
<!-- <template v-if="checkItem == 1"> -->
    
    <a href="javascript:void(0);" class="btn_wishlist" @click="onClick" v-if="checkItem == 1" :class="{on: !isActive}"></a>
    <a href="javascript:void(0);" class="btn_wishlist" @click="onClick" :class="{on: isActive}" v-else></a>
    <!-- <button class="btn btn_like" @click="onClick">

        <div class="btn_like_wrapper">
            <template v-if="checkItem == 1">
                <img src="/assets/images/SVG/i_wishlist.svg" alt="" class="i_like"
                     :class="{active: isActive}">
                <img src="/assets/images/SVG/i_wishlist_active.svg" alt="" class="i_like"
                     :class="{active: !isActive}">
            </template>
            <template v-else>
                <img src="/assets/images/SVG/i_wishlist.svg" alt="" class="i_like"
                     :class="{active: !isActive}">
                <img src="/assets/images/SVG/i_wishlist_active.svg" alt="" class="i_like"
                     :class="{active: isActive}">
            </template>
        </div>
    </button> -->
</template>

<script>
export default {
    name: 'WishlistComponent',
    props: ['dataWished'],
    data() {
        let activeItem = 0;
        if (typeof this.dataWished != 'undefined') {
            activeItem = this.dataWished;
        }
        return {
            isActive: false,
            estates: [],
            checkItem: activeItem
        };
    },
    methods: {
        onClick() {
            this.isActive = !this.isActive;
        }
    }
};
</script>

<style scoped>
.active {
    display: none;
}
</style>
