<template>
    <ul class="recommand_list">
        <li v-for="(estate, index) in estates">
            <div class="box_recommand_item">
                <a v-bind:href="'/detail/' + estate['_id']">
                <div class="box_recommand_item_img">
                    <span class="price">{{ estate['price'] }}万円</span>
                    <a v-bind:href="'/detail/' + estate['_id']"><img v-bind:src="estate['photo_first'] ? estate['photo_first'] : '/images/no-image.png'" alt="" class="img-fluid"></a>
                </div>
                <div class="box_recommand_item_content">
                    <h3>{{ estate['estate_name'] }}</h3>
                    <div class="row">
                        <div class="col-4 col-lg-3 align-self-center">
                            <h4>住所</h4>
                        </div>
                        <div class="col-8 col-lg-9 align-self-center">
                            <p>{{ estate['address']['pref'] }}{{ estate['address']['city'] }}{{ estate['address']['ooaza'] }}</p>
                        </div>
                        <div class="col-4 col-lg-3 align-self-center">
                            <h4>建物面積</h4>
                        </div>
                        <div class="col-8 col-lg-9 align-self-center">
                            <p class="gray">{{ estate['tatemono_menseki'] }}㎡</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </li>
    </ul>
</template>

<script>
	export default {
        data() {
            return {
                estates: [],
            }
        },
        beforeMount() {
            this.getListEstates();
        },
        methods: {
            getListEstates(){
                axios({url: '/list-estates', method: 'POST', data: {'limit': 9, 'page': 1}})
                    .then(resp => {
                        this.estates = this.estates.concat(resp.data['data']);
                        if (resp.data['data'].length) {
                        }
                    })
                    .catch(err => {
                        console.log('Can not get list estates');
                    }
                );
            },
        }
	};
</script>
