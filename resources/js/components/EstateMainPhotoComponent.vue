<template>
<div>
    <img class="estate_image_url" v-bind:src="url_path" />
    <input class="estate_image_file" name="estate_main_photo" type="file" @change="onFileChange"/>
</div>
</template>

<script>
    export default {
        props: ['data'],
        data(){
            let url_path = '/images/image-main.jpg';
            if (this.data){
                url_path = this.data;
            }
            return {
                url_path: url_path
            }
        },
        methods: {
            onFileChange(e) {
                const file = e.target.files[0];
                if(file){
                    this.url_path = URL.createObjectURL(file);
                    this.$forceUpdate();
                }
            }
        }
    };
</script>