<template>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <img class="estate_image_url main-photo" v-bind:src="url_path" />
        <input class="estate_image_file" name="estate_main_photo" type="file" @change="onFileChange"/>
    </div>
    <div class="col-sm-3"></div>
</div>
</template>

<script>
    export default {
        props: ['data'],
        data(){
            let url_path = '/images/image-main.jpeg';
            if (typeof JSON.parse(this.data) != 'undefined') {
                url_path = (JSON.parse(this.data)).estate_main_photo;
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