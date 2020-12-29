<template>
    <ul class="recommand_list" v-on:scroll="handleScroll">
		<li v-for="(estate, index) in estates" v-bind:class="{'estate-last' : index === (estates.length-1)}">
			<div class="box_recommand_item">
			    <div class="box_recommand_item_img">
			        <span class="price">{{ estate['price'] }}万円</span>
			        <a href="#"><img src="/design/images/rcm_01.jpg" alt="" class="img-fluid"></a>
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
			</div>
		</li>
    </ul>
</template>

<script>
	export default {
		data() {
	    	return {
	    		estates: [],
	    		page: 1,
	    		offsetTop: 0,
	    		heigthOfList: 0
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
			// Gui yeu cau den server sau moi lan cuon suong
			getListEstates(){
				axios({url: '/list-estates', method: 'POST', data: {'limit': 9, 'page': this.page}})
			        .then(resp => {
			        	this.estates = this.estates.concat(resp.data['data']);
			        	if (resp.data['data'].length) {
			        		this.page = this.page + 1;
			        	}
			        })
			        .catch(err => {
			           	console.log('Can not get list estates');
			    	}
		    	);
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
			// Do cao cua 1 dong la space (338)
			handleScroll(event){
				if(!this.heigthOfList){
					this.setInitHeigthOfList();
				}
				let space = 338 * (this.page - 2);
				console.log('Sroll at %d - Offset Top at %d - Space: %d', document.documentElement.scrollTop, this.offsetTop, space);
				if (this.offsetTop && document.documentElement.scrollTop - space > this.offsetTop) {
					this.getListEstates();
					this.setOffsetTop();
				}
			}
		}
	};
</script>
