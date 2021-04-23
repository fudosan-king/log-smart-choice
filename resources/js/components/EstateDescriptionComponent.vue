<template>
    <div class="estate-description">
        <div class="col-md-6 text-left estate-description-images">
            <img v-bind:src="url_path_left" class="estate_image_url befor-photo left-photo" />
            <input
                class="estate_description_left_photo"
                name="estate_description_left_photo"
                type="hidden"
                @change="onFileChangeLeft"
                v-if="readOnly"
            />
            <input
                class="estate_description_left_photo"
                name="estate_description_left_photo"
                @change="onFileChangeLeft"
                type="file"
                v-else
            />
            <input type="hidden" :value="url_path_left" name="estate_description_left_photo_hidden" />
        </div>
        <div class="col-md-6 text-left estate-description-images">
            <img v-bind:src="url_path_right" class="estate_image_url after-photo right-photo" />
            <input
                class="estate_description_right_photo"
                name="estate_description_right_photo"
                type="hidden"
                @change="onFileChangeRight"
                v-if="readOnly"
            />
            <input
                class="estate_description_right_photo"
                name="estate_description_right_photo"
                @change="onFileChangeRight"
                type="file"
                v-else
            />
            <input type="hidden" :value="url_path_right" name="estate_description_right_photo_hidden" />
        </div>
        <div class="form-group">
            <label for="description_title">Title</label>
            <input
                name="description_title"
                type="text"
                :value="customField.description_title"
                class="form-control"
                readonly
                v-if="readOnly"
            />
            <input
                name="description_title"
                type="text"
                :value="customField.description_title"
                class="form-control"
                v-else
            />
        </div>
        <div class="form-group">
            <label for="description_content">Content</label>
            <textarea
                name="description_content"
                :value="customField.description_content"
                class="form-control"
                rows="5"
                readonly
                v-if="readOnly"
            ></textarea>
            <textarea
                name="description_content"
                :value="customField.description_content"
                class="form-control"
                rows="5"
                v-else
            ></textarea>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data', 'data_read'],
    data() {
        let url_path_left = '/images/description/family1.png';
        let url_path_right = '/images/description/waves.png';
        let data = JSON.parse(
            this.data
                .replace(/\n/g, '\\n')
                .replace(/\r/g, '\\r')
                .replace(/\t/g, '\\t')
        );
        let customField = '';
        if (Object.keys(data)) {
            if (typeof data.custom_field != 'undefined') {
                customField = data.custom_field;
                if (customField.description_url_image_left) {
                    url_path_left = customField.description_url_image_left;
                }

                if (customField.description_url_image_right) {
                    url_path_right = customField.description_url_image_right;
                }
            }
        }

        return {
            url_path_left: url_path_left,
            url_path_right: url_path_right,
            customField: customField,
            readOnly: this.data_read
        };
    },
    methods: {
        onFileChangeLeft(e) {
            const file = e.target.files[0];
            if (file) {
                this.url_path_left = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        },
        onFileChangeRight(e) {
            const file = e.target.files[0];
            if (file) {
                this.url_path_right = URL.createObjectURL(file);
                this.$forceUpdate();
            }
        }
    }
};
</script>
