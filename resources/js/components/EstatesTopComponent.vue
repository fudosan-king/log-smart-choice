<template>
    <ul class="list_property">
        <li v-for="(estate, index) in estates">
            <div class="box_property_item">
                <div class="box_property_item_img">
                    <a v-bind:href="'/detail/' + estate._id">
                        <img v-bind:src="estate['photo_first'] ? estate.photo_first : '/images/no-image.png'" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="box_property_item_body">
                    <h2><a v-bind:href="'/detail/' + estate._id">{{ estate.custom_field ? estate.custom_field.content : "" }}</a></h2>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p>{{ estate.room_count }}{{ estate.service_rooms != '0' ? 'S' : '' }}{{ estate.room_kind }} / {{estate.tatemono_menseki }}㎡</p>
                        </div>
                        <!-- <div class="col-12 col-lg-6">
                            <p class="property_info">
                                <span>30代ご夫婦</span>
                                <span>お子様2人</span>
                            </p>
                        </div> -->
                    </div>
                </div>
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
                let accessToken = this.$getCookie('accessToken');
                if (accessToken != '') {
                    axios({
                        url: '/customer', 
                        method: 'POST', 
                        data: {}, 
                        headers: {
                            'content-type': 'application/json',
                            'Authorization': `Bearer ${accessToken}`,
                        },
                        })
                        .then(resp => {
                            let emailCustomer = resp.data.customer.email;
                            axios({url: '/list', method: 'POST', data: {'limit': 10, 'page': 1, 'email' : emailCustomer}})
                                .then(resp => {
                                    this.estates = this.estates.concat(resp.data['data']);
                                })
                                .catch(err => {
                                    console.log('Can not get list estates');
                                }
                            );
                        })
                        .catch(err => {});
                } else {
                    axios({url: '/list', method: 'POST', data: {'limit': 10, 'page': 1}})
                        .then(resp => {
                            this.estates = this.estates.concat(resp.data['data']);
                            if (resp.data['data'].length) {
                            }
                        })
                        .catch(err => {
                            console.log('Can not get list estates');
                        }
                    );
                }
            },
        }
	};
</script>
