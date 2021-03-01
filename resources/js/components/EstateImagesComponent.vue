<template>
<div class="form-group hp_photo_wrap" id="hp_photo_wrap">
    <ul id="sortable">
        <draggable @start="drag=true" @end="drag=false">
        <li id="imageInfo" v-for="(image, idx) in images" :key="idx">
            <h3>Image</h3>
            <div class="img-wrap" style="text-align: right;">
                <a class="remove-image" @click="removeImage(idx)">&times;</a>
            </div>
            <img class="estate_image_url image-photo" v-bind:src=image[0] />
            <input class="estate_image_file" name="estate_image[]" type="file" @change="onFileChange" v-bind:data-index-image=idx />
            <input name="estate_image_hidden[]" type="hidden" v-bind:value=image[0] />
            <div class="photo_info">
                <textarea class="form-control" name="description[]">{{ image[1] }}</textarea>
            </div>
        </li>
        </draggable>
    </ul>
    <button type="button" class="btn btn-primary append-image" @click="addImage">Append Images</button>
</div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable,
        },
        props: ['data'],
        data(){
            let images = [];
            if (Object.keys(JSON.parse(this.data))) {
                if (typeof (JSON.parse(this.data)).renovation_media != 'undefined') {
                    const renovation_media = (JSON.parse(this.data)).renovation_media;
                    for(let i = 0; i < renovation_media.length; i++) {
                        const url = renovation_media[i]['url_path'];
                        images.push([url, renovation_media[i]['description']]);
                    }
                }
            }
            return {
                images: images,
            }
        },
        methods: {
            addImage(){
                this.images.push(['/images/no-image.png', '']);
            },
            removeImage(idx){
                this.$delete(this.images, idx);
            },
            onFileChange(e) {
                const file = e.target.files[0];
                if(file){
                    this.images[e.target.dataset.indexImage][0] = URL.createObjectURL(file);
                    this.$forceUpdate();
                }
            }
        }
    }
</script>