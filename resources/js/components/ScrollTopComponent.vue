<template>
    <a @click="scrollTop" v-show="visible">
        <slot></slot>
        <div v-bind:style="styleScrollTop"></div>
    </a>
</template>

<script>
export default {
    data() {
        const footerArrow = '/assets/images/footer_arrow.png';
        const styleScrollTop = {
            "backgroundImage": "url(" + footerArrow + ")",
            "padding-bottom": "100%",
            "width": "56px",
        };

        return {
            visible: false,
            footerArrow: footerArrow,
            styleScrollTop: styleScrollTop,
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
