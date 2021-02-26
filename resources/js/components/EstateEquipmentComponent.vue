<template>
    <div class="form-group hp_photo_wrap" id="hp_photo_wrap">
        <ul class="sortable">
            <draggable @start="drag = true" @end="drag = false">
                <li class="imageInfo" v-for="(slide, idx) in slides" :key="idx">
                    <h3>Image</h3>
                    <div class="img-wrap" style="text-align: right;" v-if="readOnly != true">
                        <a class="remove-image" @click="removeImage(idx)">&times;</a>
                    </div>
                    <img class="estate_image_url image-photo equipment-estate" v-bind:src="slide[0]" />
                    <input
                        class="estate_image_file"
                        name="estate_image_equipment[]"
                        type="file"
                        @change="onFileChange"
                        v-bind:data-index-image="idx"
                        v-if="readOnly"
                        readonly
                    />
                    <input
                        class="estate_image_file"
                        name="estate_image_equipment[]"
                        type="file"
                        @change="onFileChange"
                        v-bind:data-index-image="idx"
                        v-else
                    />
                    <input readonly name="estate_image_equipment_hidden[]" type="hidden" v-bind:value="slide[0]" />
                    <div class="photo_info">
                        <textarea
                            v-if="readOnly"
                            readonly
                            placeholder="Caption"
                            class="form-control"
                            name="estate_image_equipment_caption[]"
                            >{{ slide[1] }}</textarea
                        >
                        <textarea
                            v-else
                            placeholder="Caption"
                            class="form-control"
                            name="estate_image_equipment_caption[]"
                            >{{ slide[1] }}</textarea
                        >
                    </div>
                </li>
            </draggable>
        </ul>

        <button v-if="readOnly != true" type="button" class="btn btn-primary append-image" @click="addImage">
            Append Images
        </button>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
export default {
    components: {
        draggable
    },
    props: ['data', 'data_read'],
    data() {
        let slides = [];
        if (JSON.parse(this.data)) {
            let data = JSON.parse(this.data);
            if (data.estate_equipment) {
                const slidesEquipment = data.estate_equipment;
                for (let i = 0; i < slidesEquipment.length; i++) {
                    slides.push([slidesEquipment[i]['slide_equipment'], slidesEquipment[i]['caption_equipment']]);
                }
            }
        }

        return {
            slides: slides,
            readOnly: this.data_read
        };
    },
    methods: {
        addImage() {
            this.slides.push(['/images/no-image.png', '']);
        },
        removeImage(idx) {
            this.$delete(this.slides, idx);
        },
        onFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.slides[e.target.dataset.indexImage][0] = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        }
    }
};
</script>
