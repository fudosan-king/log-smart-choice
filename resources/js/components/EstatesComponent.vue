<template>
	<div class="col-12 col-lg-12">
	    <ul class="list_property" v-on:scroll="handleScroll">
            <li v-for="(estate, index) in estates" :key="index._id" v-bind:class="{'estate-last' : index === (estates.length-1)}">
                <div class="box_property_item">
                    <div class="box_property_item_img">
                        <a v-bind:href="'/detail/' + estate._id">
                            <img v-bind:src="estate.photo_first ? estate.photo_first : '/images/no-image.png'" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="box_property_item_body">
                        <h2><a v-bind:href="'/detail/' + estate._id">{{ estate.custom_field ? estate.custom_field.content : "" }}</a></h2>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <p>{{ estate.room_count }}{{ estate.service_rooms != '0' ? 'S' : '' }}{{ estate.room_kind }} / {{estate.tatemono_menseki }}㎡</p>
                            </div>
                            <div class="col-12 col-lg-6">
                                <!-- <p class="property_info">
                                    <span>30代ご夫婦</span>
                                    <span>お子様2人</span>
                                </p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </li>
         </ul>
	    <div class="loading" v-if="!isHidden" style="text-align: center;">
			<img src="/images/loading.gif">
		</div>
	</div>
</template>

<script>
	export default {
		data() {
	    	return {
	    		estates: [],
	    		page: 1,
	    		offsetTop: 0,
	    		heigthOfList: 0,
	    		isHidden: false
	    	}
	    },
	    beforeMount() {
	    	this.getListEstates();
	    },
	    created() {
	        window.addEventListener('scroll', this.handleScroll);
    	},
    	destroyed () {
		  	window.removeEventListener('scroll', this.handleScroll);
		},
		methods: {
			// Gui yeu cau den server sau moi lan cuon xuong
			getListEstates(){
                let accessToken = this.$getCookie('accessToken');
                let auth = {
                    username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                    password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
                }
                if (accessToken != '') {
                    axios({
                        url: '/customer', 
                        method: 'POST', 
                        data: {}, 
                        headers: {
                            'content-type': 'application/json',
                            'AuthorizationBearer': `Bearer ${accessToken}`,
                        },
                        auth: auth,
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
                    axios({url: '/list', method: 'POST', data: {'limit': 10, 'page': 1}, headers: {
                            'content-type': 'application/json',
                            'Authorization': `Bearer ${accessToken}`,
                        },})
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
			// Khi them danh sach phia duoi thi tinh toan lai do cao
			setOffsetTop(){
				this.offsetTop = this.offsetTop + this.heigthOfList;
			},
			// Tinh do cao cua danh sach sao cho cuon xuong duoi cung thi gui API
			setInitHeigthOfList(){
				let estate_last = this.$el.querySelector('.estate-last');
				if (estate_last){
					this.heigthOfList = estate_last.offsetTop;
					this.offsetTop = estate_last.offsetTop;
				}
			},
			// Su kien cuon mouse.
			// Do cao cua 1 dong la space (423)
			handleScroll(event){
				if(!this.heigthOfList){
					this.setInitHeigthOfList();
				}
				let space = 423 * (this.page - 2);
				// console.log('Sroll at %d - Offset Top at %d - Space: %d', document.documentElement.scrollTop, this.offsetTop, space);
				if (this.offsetTop && document.documentElement.scrollTop - space > this.offsetTop) {
					this.isHidden = false;
					this.getListEstates();
					this.setOffsetTop();
				}
			}
		}
	};
</script>
