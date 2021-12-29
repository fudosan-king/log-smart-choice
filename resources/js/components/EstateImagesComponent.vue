<template>
    <div class="form-group hp_photo_wrap" id="hp_photo_wrap">
        <ul id="sortable">
            <!-- <draggable @start="drag = true" @end="drag = false"> -->
            <template v-if="images">
                <li class="imageInfo" v-for="(image, idx) in images" :key="idx">
                    <h3>Image</h3>
                    <template v-if="flag == 'estate'">
                        <div class="img-wrap" style="text-align: right;">
                            <a class="remove-image" @click="removeImage(idx)">&times;</a>
                        </div>
                    </template>

                    <img class="estate_image_url image-photo" v-bind:src="image[0]" />
                    <input
                        class="estate_image_file"
                        name="estate_image[]"
                        type="file"
                        @change="onFileChange"
                        v-bind:data-index-image="idx"
                    />
                    <input name="estate_image_hidden[]" type="hidden" v-bind:value="image[0]" />
                    <div class="photo_info">
                        <textarea class="form-control" rows="10" cols="40" name="description[]" style="display:none;">{{
                            image[1]
                        }}</textarea>
                        <ckeditor v-model="image[1]" :config="editorConfig" tag-name="textarea"></ckeditor>
                    </div>
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
// import draggable from 'vuedraggable';
import Vue from 'vue';
import CKEDITOR from 'ckeditor4-vue';

Vue.use(CKEDITOR);

export default {
    components: {
        // draggable
    },
    props: ['data', 'flag'],
    data() {
        let images = [];
        let data = this.data;
        if (this.flag == 'estate') {
            if (typeof data.renovation_media != 'undefined') {
                const renovation_media = data.renovation_media;
                for (let i = 0; i < renovation_media.length; i++) {
                    const url = renovation_media[i]['url_path'];
                    images.push([url, renovation_media[i]['description']]);
                }
            }
        } else if (this.flag == 'post') {
            if (this.data[0]) {
                let content = this.data[0].content;
                images.push([this.data[0].top_image, content]);
            } else {
                images.push(['/images/no-image.png']);
            }
        }

        return {
            images: images,
            editorConfig: {
                toolbar: [
                    ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat'],
                    ['NumberedList', 'BulletdList', '-', 'Outdent', 'Indent', '-', 'Blockquote'],
                    ['Styles', 'Format']
                ]
            }
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
