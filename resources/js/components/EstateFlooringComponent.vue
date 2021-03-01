<template>
    <div class="form-group hp_photo_wrap" id="hp_photo_wrap">
        <ul class="sortable">
            <draggable @start="drag = true" @end="drag = false">
                <li class="imageInfo" v-for="(flooring, index) in floorings" :key="index">
                    <h3>Image</h3>
                    <div class="img-wrap" style="text-align: right;" v-if="readOnly != true">
                        <a class="remove-image" @click="removeImage(index)">&times;</a>
                    </div>
                    <img class="estate_image_url image-photo flooring-estate" :src="flooring[0]" />
                    <input
                        class="estate_image_file"
                        name="estate_image_flooring[]"
                        type="file"
                        @change="onFileChange"
                        :data-index-image="index"
                    />
                    <input name="estate_image_flooring_hidden[]" type="hidden" :value="flooring[0]" />
                    <input v-if="readOnly" readonly placeholder="Title" class="estate_flooring_title" type="text" v-model="flooring[1]" name="estate_flooring_title[]" />
                    <input v-else placeholder="Title" class="estate_flooring_title" type="text" v-model="flooring[1]" name="estate_flooring_title[]" />
                    <div class="photo_info">
                        <textarea v-if="readOnly" readonly placeholder="Content" class="form-control" name="estate_flooring_content[]">{{ flooring[2] }}</textarea>
                        <textarea v-else placeholder="Content" class="form-control" name="estate_flooring_content[]">{{ flooring[2] }}</textarea>
                    </div>
                </li>
            </draggable>
        </ul>

        <button v-if="readOnly != true" type="button" class="btn btn-primary append-image" @click="addImage">Append Images</button>
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
        let floorings = [];
        if (Object.key(JSON.parse(this.data)).length) {
            let data  = JSON.parse(this.data);
            if (typeof (JSON.parse(data)).estate_flooring != 'undefined') {
                const estateFloorings = data.estate_flooring;
                for (let i = 0; i < estateFloorings.length; i++) {
                    floorings.push([
                        estateFloorings[i]['flooring_image_url'],
                        estateFloorings[i]['flooring_title'],
                        estateFloorings[i]['flooring_content']
                    ]);
                }
            }
        }

        return {
            floorings: floorings,
            readOnly: this.data_read,
        };
    },
    methods: {
        addImage() {
            this.floorings.push(['/images/no-image.png', '']);
        },
        removeImage(index) {
            this.$delete(this.floorings, index);
        },
        onFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.floorings[e.target.dataset.indexImage][0] = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        }
    }
};
</script>
