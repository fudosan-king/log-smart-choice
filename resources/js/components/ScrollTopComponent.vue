<template>
    <a @click="scrollTop" v-show="visible">
        <slot></slot>
        <div class="bottom-arrow-top" v-bind:style="{ backgroundImage: 'url(' + footerArrow + ')' }"></div>
    </a>
</template>

<script>
export default {
    data() {
        const footerArrow = '/assets/images/footer_arrow.png';
        return {
            visible: false,
            footerArrow: footerArrow
        };
    },
    methods: {
        scrollTop: function() {
            this.intervalId = setInterval(() => {
                if (window.pageYOffset === 0) {
                    clearInterval(this.intervalId);
                }
                window.scroll(0, window.pageYOffset - 50);
            }, 20);
        },
        scrollListener: function(e) {
            this.visible = window.scrollY > 150;
        }
    },
    mounted: function() {
        window.addEventListener('scroll', this.scrollListener);
    },
    beforeDestroy: function() {
        window.removeEventListener('scroll', this.scrollListener);
    }
};
</script>
<style>
.bottom-arrow-top {
    padding-bottom: 100%;
    width: 56px;
}
</style>
