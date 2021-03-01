<template>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-4 text-center">
        <img v-bind:src="url_path_befor" class="estate_image_url befor-photo">
        <input name="estate_befor_photo" class="estate_befor_photo" type="file" @change="onFileChangeBefor">
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4 text-center">
        <img v-bind:src="url_path_after" class="estate_image_url after-photo">
        <input name="estate_after_photo" class="estate_after_photo" type="file" @change="onFileChangeAfter">
    </div>
    <div class="col-md-1"></div>
</div>
</template>

<script>
    export default {
        props: ['befor', 'after'],
        data(){
            let url_path_befor = '/images/befor.png';
            
            if (Object.keys(JSON.parse(this.befor)).length){
                if (typeof (JSON.parse(this.after)).estate_befor_photo != 'undefined') {
                    url_path_befor = (JSON.parse(this.befor)).estate_befor_photo;
                }
            }
            let url_path_after = '/images/after.png';
            if (Object.keys(JSON.parse(this.after)).length){
                if (typeof (JSON.parse(this.after)).estate_after_photo != 'undefined') {
                    url_path_after = (JSON.parse(this.after)).estate_after_photo;
                }
            }
            return {
                url_path_befor: url_path_befor,
                url_path_after: url_path_after
            }
        },
        methods: {
            onFileChangeBefor(e) {
                const file = e.target.files[0];
                if(file){
                    this.url_path_befor = URL.createObjectURL(file);
                    this.$forceUpdate();
                }
            },
            onFileChangeAfter(e) {
                const file = e.target.files[0];
                if(file){
                    this.url_path_after = URL.createObjectURL(file);
                    this.$forceUpdate();
                }
            }
        }
    };
</script>