<template>
<div>
    <div class="col-md-6 text-center">
        <img v-bind:src="url_path_befor" class="estate_image_url befor-photo">
        <input name="estate_befor_photo" type="file" @change="onFileChangeBefor">
    </div>
    <div class="col-md-6 text-center">
        <img v-bind:src="url_path_after" class="estate_image_url after-photo">
        <input name="estate_after_photo" type="file" @change="onFileChangeAfter">
    </div>
</div>
</template>

<script>
    export default {
        props: ['befor', 'after'],
        data(){
            let url_path_befor = '/images/befor.png';
            if (this.befor){
                url_path_befor = this.befor;
            }
            let url_path_after = '/images/after.png';
            if (this.after){
                url_path_after = this.after;
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