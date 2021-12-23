<template>
    <div class="form-group hp_photo_wrap" id="hp_photo_wrap">
        <ul id="sortable">
            <!-- <draggable @start="drag = true" @end="drag = false"> -->
            <template v-if="images">
                <li id="imageInfo" v-for="(image, idx) in images" :key="idx">
                    <h3>Image</h3>
                    <div class="img-wrap" style="text-align: right;">
                        <a class="remove-image" @click="removeImage(idx)">&times;</a>
                    </div>
                    <img class="estate_image_url image-photo" v-bind:src="image[0]" />
                    <input
                        class="estate_image_file"
                        name="estate_main_photo[]"
                        type="file"
                        @change="onFileChange"
                        v-bind:data-index-image="idx"
                    />
                    <input name="estate_main_photo_hidden[]" type="hidden" v-bind:value="image[0]" />
                </li>
            </template>

            <!-- </draggable> -->
        </ul>
        <button type="button" class="btn btn-primary append-image" @click="addImage">Append Images</button>
    </div>
</template>

<script>
// import draggable from 'vuedraggable';
export default {
    components: {
        // draggable
    },
    props: ['data'],
    data() {
        let images = [];
        let data = this.data;
        if (typeof data.estate_main_photo != 'undefined') {
            const mainPhoto = data.estate_main_photo;
            for (let i = 0; i < mainPhoto.length; i++) {
                const url = mainPhoto[i]['url_path'];
                images.push([url, mainPhoto[i]['description']]);
            }
        }

        return {
            images: images
        };
    },
    methods: {
        addImage() {
            this.images.push(['/images/no-image.png', '']);
        },
        removeImage(idx) {
            this.$delete(this.images, idx);
        },
        onFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.images[e.target.dataset.indexImage][0] = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        }
    }
};
</script>
