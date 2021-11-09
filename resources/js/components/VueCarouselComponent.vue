<template>
  <carousel :data="slider" :controls="true" :autoplay="true"></carousel>
</template>

<script>
	// import {VueCarousel, Slide} from '@chenfengyuan/vue-carousel'
	export default {
	  	components: {
	      	VueCarousel: () => import('@chenfengyuan/vue-carousel'),
	      	Slide: () => import('@chenfengyuan/vue-carousel')
	    },
	    props: ['data'],
	    data() {
            let slider = [];
            let data = JSON.parse(this.data);
            if (Object.keys(data)) {
                if (typeof data.renovation_media != 'undefined') {
                    let renovationMedia = data.renovation_media;
                    for(let i=0; i < renovationMedia.length; i++){
                        slider.push('<div class="example-slide"><img src=' + renovationMedia[i]['url_path'] +'> </div>');
                    }
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