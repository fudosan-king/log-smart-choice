<template>
    <div class="form-group hp_photo_wrap" id="hp_photo_wrap">
        <ul id="sortable">
            <!-- <draggable @start="drag = true" @end="drag = false"> -->
            <template v-if="images">
                <li id="imageInfo" v-for="(image, idx) in images" :key="idx">
                    <h3>Image</h3>
                    <template v-if="flag == 'estate'">
                        <div class="img-wrap" style="text-align: right">
                            <a class="remove-image" @click="removeImage(idx)">&times;</a>
                        </div>
                    </template>

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
        <template v-if="flag == 'estate'">
            <button type="button" class="btn btn-primary append-image" @click="addImage">Append Images</button>
        </template>
    </div>
</template>

<script>
import uploadImagesMixin from '../mixins/uploadImagesMixin';

export default {
    props: ['data', 'flag'],
    mixins: [uploadImagesMixin],
    data() {
        let images = [];
        let data = this.data;
        if (this.flag == 'estate') {
            if (typeof data.estate_main_photo != 'undefined') {
                const mainPhoto = data.estate_main_photo;
                for (let i = 0; i < mainPhoto.length; i++) {
                    const url = mainPhoto[i]['url_path'];
                    images.push([url, mainPhoto[i]['description']]);
                }
            }
        } else if (this.flag == 'post') {
            if (this.data[0]) {
                images.push([this.data[0].title_image]);
            } else {
                images.push(['/images/no-image.png']);
            }
        }

        return {
            images: images
        };
    }
};
</script>
