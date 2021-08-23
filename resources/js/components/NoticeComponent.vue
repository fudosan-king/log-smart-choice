<template>
    <div class="col-12 col-lg-12">
        <template v-for="(announcement, index) in announcementList">
            <div v-if="!announcement.is_read && announcement.status == '公開中'"
                class="box_notice_item new"
                :key="index._id"
                v-bind:class="{ 'estate-last': index === announcementList.length - 1 }"
            >
                <div class="row no-gutters">
                    <div class="col-5 col-lg-6">
                        <div class="box_notice_img">
                            <a
                                href="javascript:void(0)"
                                v-on:click="readAnnouncement(announcement.announcement_id, announcement._id)"
                            >
                                <img
                                    v-lazy="
                                        announcement.estate_information.estate_main_photo.length
                                            ? announcement.estate_information.estate_main_photo[0].url_path
                                            : '/images/no-image.png'
                                    "
                                    alt=""
                                    class="img-fluid"
                                />
                            </a>
                            <span>新着物件</span>
                        </div>
                    </div>
                    <div class="col-7 col-lg-6">
                        <div class="box_notice_content">
                            <p>{{ announcement.announcement_created_at }}</p>
                            <p>
                                <a
                                    href="javascript:void(0)"
                                    v-on:click="readAnnouncement(announcement.announcement_id, announcement._id)"
                                    >{{ announcement.estate_name }}</a
                                >
                            </p>
                            <p>{{ announcement.tatemono_menseki }}m²</p>
                            <p>{{ announcement.total_price }}万円（物件＋リノベーション）</p>
                        </div>
                    </div>
                </div>
                <a class="btn_del" @click="deleteAnnouncement(announcement.announcement_id, announcement)">
                    <img
                        src="images/svg/i_delete.svg"
                        alt=""
                        class="img-fluid d-none d-lg-block curser-pointer"
                        width="20"
                    />
                    <img src="images/svg/i_delete_white.svg" alt="" class="img-fluid d-block d-lg-none" width="20" />
                </a>
            </div>
            <div v-else-if="announcement.is_read" 
                class="box_notice_item"
                :key="index._id"
                v-bind:class="{ 'estate-last': index === announcementList.length - 1 }"
            >
                <div class="row no-gutters">
                    <div class="col-5 col-lg-6">
                        <div class="box_notice_img">
                            <a
                                href="javascript:void(0)"
                                v-on:click="readAnnouncement(announcement.announcement_id, announcement._id)"
                            >
                                <img
                                    v-lazy="
                                        announcement.estate_information.estate_main_photo.length
                                            ? announcement.estate_information.estate_main_photo[0].url_path
                                            : '/images/no-image.png'
                                    "
                                    alt=""
                                    class="img-fluid"
                                />
                            </a>
                            <span v-if="announcement.status != '公開中'"> 成約済</span>
                            <span v-else>新規物件</span>
                        </div>
                    </div>
                    <div class="col-7 col-lg-6">
                        <div class="box_notice_content">
                            <p>{{ announcement.announcement_created_at }}</p>
                            <p>
                                <a
                                    href="javascript:void(0)"
                                    v-on:click="readAnnouncement(announcement.announcement_id, announcement._id)"
                                    >{{ announcement.estate_name }}</a
                                >
                            </p>
                            <p>{{ announcement.tatemono_menseki }}m²</p>
                            <p>{{ announcement.total_price }}万円（物件＋リノベーション）</p>
                        </div>
                    </div>
                </div>
                <a class="btn_del" @click="deleteAnnouncement(announcement.announcement_id, announcement)">
                    <img
                        src="images/svg/i_delete.svg"
                        alt=""
                        class="img-fluid d-none d-lg-block curser-pointer"
                        width="20"
                    />
                    <img src="images/svg/i_delete_white.svg" alt="" class="img-fluid d-block d-lg-none" width="20" />
                </a>
            </div>
        </template>
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
            lastEstate: [],
            hasMore: true
        };
    },
    mounted() {
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
                    if (typeof res[0] === 'undefined') {
                        this.announcementList = this.announcementList.concat(res.data.data);
                    } else {
                        this.announcementList = this.announcementList.concat(res[0]['data']['data']);
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

        deleteAnnouncement(announcementID, announcement) {
            let data = {
                id: [announcementID]
            };
            this.$store.dispatch('deleteAnnoutcement', data).then(res => {
                this.announcementList.splice(this.announcementList.indexOf(announcement), 1);
            });
        },

        readAnnouncement(announcementID, estetaId) {
            let data = {
                id: announcementID
            };
            this.$store.dispatch('readAnnouncement', data).then(res => {
                if (typeof res[0] === 'undefined') {
                    let annoucementCount = res.data.data;
                    this.$setCookie('announcement_count', annoucementCount.announcement_count, 1);
                } else {
                    let annoucementCount = res[0]['data']['data'];
                    this.$setCookie('announcement_count', annoucementCount.announcement_count, 1);
                }
                this.$router.push({ path: 'detail/' + estetaId });
            });
        }
    }
};
</script>
