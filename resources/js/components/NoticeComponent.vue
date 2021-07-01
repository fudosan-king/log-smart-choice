<template>
    <div class="col-12 col-lg-12">
         <div class="box_notice_item" 
            v-for="(announcement, index) in announcementList"
            :key="index._id"
            v-bind:class="{ 'estate-last': index === announcementList.length - 1 }"
        >
            <div class="row no-gutters">
                <div class="col-5 col-lg-6">
                    <div class="box_notice_img">
                        <a href="#">
                            <img 
                            v-lazy="
                                typeof announcement.estate_information[0] !== 'undefined' && typeof announcement.estate_information[0].url_path !== 'undefined'
                                    ? announcement.estate_information.estate_main_photo[0].url_path
                                    : '/images/no-image.png'
                            "
                            alt="" class="img-fluid">
                        </a>
                        <span>新着物件</span>
                    </div>
                </div>
                <div class="col-7 col-lg-6">
                    <div class="box_notice_content">
                        <p>1日前</p>
                        <p><a href="#">{{ announcement.estate_name }}</a></p>
                        <p>{{announcement.tatemono_menseki}}m²</p>
                        <p>{{ announcement.total_price }}万円（物件＋リノベーション）</p>
                    </div>
                </div>
            </div>
            <a class="btn_del" @click="deleteAnnouncement(announcement.announcementID)">
                <img src="images/svg/i_delete.svg" alt="" class="img-fluid d-none d-lg-block" width="20">
                <img src="images/svg/i_delete_white.svg" alt="" class="img-fluid d-block d-lg-none" width="20">
            </a>
        </div>
        <div class="loading" v-if="hasMore" style="text-align: center;">
            <img v-lazy="`/images/loading.gif`" style="width: 100%;" />
        </div>
    </div>
</template>

<script>
import announcementModule from '../store/modules/announcement.js';
import Lazyload from 'vue-lazyload';
import Vue from 'vue';

Vue.use(Lazyload, {
    preLoad: 1.3,
    error: 'images/no-image.png',
    loading: 'images/loading.gif',
    attempt: 1
});
export default {
    data() {
        return {
            announcementList: [],
            page: 2,
            limit: 10,
            offsetTop: 0,
            heigthOfList: 0,
            accessToken: false,
            lastEstate:[],
            hasMore: true,
        };
    },
    beforeMount() {
        this.getAnnouncementList(1, this.limit);
    },
    created() {
        this.$store.registerModule('announcement', announcementModule);
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy() {
        this.$store.unregisterModule('announcement');
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        // Gui yeu cau den server sau moi lan cuon xuong
        getAnnouncementList(pageLoad) {

            let accessToken = this.$getCookie('accessToken');
            let data = {
                limit: this.limit,
                page: pageLoad
            };
            if (accessToken.length > 0) {
                this.$store.dispatch('getAnnouncementList', data).then(res => {
                    this.announcementList = this.announcementList.concat(res[0]['data']['data']);
                    if (this.announcementList.length < res[0]['data'].total) {
                        this.hasMore = true;
                    } else {
                        this.hasMore = false;
                    }
                });
            }
        },
        // Khi them danh sach phia duoi thi tinh toan lai do cao
        setOffsetTop() {
            this.offsetTop = this.offsetTop + this.heigthOfList;
        },
        // Tinh do cao cua danh sach sao cho cuon xuong duoi cung thi gui API
        setInitHeigthOfList() {
            let estate_last = this.$el.querySelector('.estate-last');
            if (estate_last) {
                this.heigthOfList = estate_last.offsetTop;
                this.offsetTop = estate_last.offsetTop;
            }
        },
        // Su kien cuon mouse.
        // Do cao cua 1 dong la space (423)
        handleScroll(event) {
            if (!this.heigthOfList) {
                this.setInitHeigthOfList();
            }
            let space = 423 * (this.page - 2);
            // console.log('Sroll at %d - Offset Top at %d - Space: %d', document.documentElement.scrollTop, this.offsetTop, space);
            if (document.documentElement.scrollTop - space > this.offsetTop) {
                this.isHidden = false;
                if (this.hasMore) {
                    this.getAnnouncementList(this.page);
                    this.setOffsetTop();
                    this.page++;
                }
            }
        },

        // Add states to wishlist
        
        deleteAnnouncement(announcementID) {
            let accessToken = this.$getCookie('accessToken');
            if (accessToken != '') {
                let data = {
                    id: [announcementID]
                }
                this.$store.dispatch('deleteAnnoutcement', data, accessToken)
                .then(res => {
                    if (res[0].status === 200) {
                        this.announcementList = this.announcementList.filter(announcement => announcement.announcementID !== announcementID);
                    }
                });
            }
        }
    }
};
</script>
