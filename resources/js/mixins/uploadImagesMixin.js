export default {
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
    },
}