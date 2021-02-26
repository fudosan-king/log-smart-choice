<template>
  <carousel :data="slider" :controls="true" :autoplay="true"></carousel>
</template>

<script>
	import {VueCarousel, Slide} from '@chenfengyuan/vue-carousel'
	export default {
	  	components: {
	      	VueCarousel,
	      	Slide
	    },
	    props: ['data'],
	    data() {
            let slider = [];
            if (typeof JSON.parse(this.data).renovation_media != null) {
                let data = JSON.parse(this.data).renovation_media;
                for(let i=0; i < data.length; i++){
                    slider.push('<div class="example-slide"><img src=' + data[i]['url_path'] +'> </div>');
                }
            }
	      	return {
	        	slider: slider
	      	};
	    },
	};
</script>

<style>
  .example-slide {
    align-items: center;
    background-color: #666;
    color: #999;
    display: flex;
    font-size: 1.5rem;
    justify-content: center;
    min-height: 10rem;
  }
</style>