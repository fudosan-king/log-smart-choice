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
                    <img class="estate_image_url image-photo" v-bind:src="image" />
                    <input
                        class="estate_image_file"
                        name="post_main_photo[]"
                        type="file"
                        @change="onFileChange"
                        v-bind:data-index-image="idx"
                    />
                    <input name="post_main_photo_hidden[]" type="hidden" v-bind:value="image" />
                </li>
            </template>

            <!-- </draggable> -->
        </ul>
        <template v-if="count < 3">
            <button type="button" class="btn btn-primary append-image" @click="addImage">Append Images</button>
        </template>
    </div>
</template>

<script>
export default {
    props: ['data', 'flag'],
    data() {
        let images = [];
        if (this.flag == 'post') {
            if (typeof this.data != 'undefined') {
                this.data.forEach(e => {
                    images.push(e.image_url);
                });
            }
        }
        let count = 0;
        return {
            images: images,
            count : count
        };
    },
    methods: {
        addImage() {
            this.images.push(['/images/no-image.png']);
            this.count ++;
        },
        removeImage(idx) {
            this.$delete(this.images, idx);
            this.count --;
        },
        onFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.images[e.target.dataset.indexImage] = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        }
    }
};
</script>
