<template>
    <section class="section_searh search-show">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12" >
                    <!-- <h4>会員登録情報 <a v-on:click="handleClose($event)">Close</a></h4> -->
                    <div class="box_searchby area" v-if="searchType === 'district'">
                        <h3>
                            <a class="btn" v-on:click="handleClose($event)"><span>エリアから探す</span></a></h3>
                        <div v-if="districtLoading" class="lsc-spinner">
                            <div  class="spinner-border text-danger" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <ul v-else id="box_byarea" class="collapse">
                            <li v-for="district in districtList" :key="district.code">
                                <a
                                    href="javascript:void(0)"
                                    v-on:click="searchDistrict($event, district.name, district.code)"
                                >
                                    {{ district.name }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="box_searchby line" v-else>
                        <h3>
                            <a class="btn" 
                                v-on:click="handleClose($event)"
                            ><span>沿線から探す</span></a>
                        </h3>
                        <div v-if="companyLoading" class="lsc-spinner">
                            <div  class="spinner-border text-danger" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <ul v-else id="box_byline" class="collapse">
                            <li v-for="company in companyList" :key="company.tran_company_code">
                                <a
                                    class="station-item"
                                    href="javascript:void(0)"
                                    v-on:click="searchStation($event, company.tran_company_code, company.tran_company_short_name)"
                                >
                                    {{ company.tran_company_short_name }}
                                </a>
                            </li>
                        </ul>
                    </div>


                    <!-- <div class="row no-gutters">
                        <div class="col-12 col-lg-12 align-self-center districts" v-if="searchType === 'district'">
                            <div v-if="districtLoading" class="spinner-border text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <ul v-else>
                                <li v-for="district in districtList" :key="district.id">
                                    <a
                                        href="javascript:void(0)"
                                        v-on:click="searchDistrict(district.name)"
                                        >{{ district.name }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-12 align-self-center stations" v-else>
                            <div v-if="stationLoading" class="spinner-border text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <ul v-else>
                                <li v-for="station in stationList" :key="station.id">
                                    <a
                                        class="station-item"
                                        href="javascript:void(0)"
                                        v-on:click="searchStation(station)"
                                        >{{ station }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'SearchComponent',
    props: ['searchType'],
    data() {
        return {
            districtLoading: true,
            stationLoading: true,
            companyLoading: true,
            districtList: {},
            stationList: {},
            companyList: {}
        };
    },
    watch: {
        searchType: function(newValue, oldValue) {
            if (newValue === '') {
                return;
            }
            if(newValue == 'district') {
                this.getDistrict();
            } else {
                this.getTransportCompany();
            }
        },
    },
    mounted() {
        if(this.searchType == 'district') {
            this.getDistrict();
        } else {
            this.getTransportCompany();
        }
    },
    methods: {
        getDistrict() {
            this.$store.dispatch('getDistrict').then(response => {
                this.districtList = response.data;
                this.districtLoading = false;
            });
        },

        // getStation() {
        //     this.$store.dispatch('getStation').then(response => {
        //         this.stationList = response;
        //         this.stationLoading = false;
        //     });
        // },

        getTransportCompany() {
            this.$store.dispatch('getTransportCompany').then(response => {
                this.companyList = response;
                this.companyLoading = false;
            });
        },
        searchDistrict(event, districtName, districtCode) {
            event.preventDefault();
            let cookieStation = this.$getCookie('station');
            if (cookieStation.length > 0) {
                this.$setCookie('station', '', 1);
            }
            this.$setCookie('district', districtName, 1);
            this.$router
                .push({ name: 'listByCode', params: {searchCode: districtCode} })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },

        searchStation(event, companyCode, companyName) {
            event.preventDefault();
            let cookieDistrict = this.$getCookie('district');
            if (cookieDistrict.length > 0) {
                this.$setCookie('district', '', 1);
            }
            this.$setCookie('station', companyName, 1);
            this.$router
                .push({ name: 'listByCode', params: {searchCode: companyCode} })
                .then(() => {
                    this.$router.go('0');
                })
                .catch(() => {
                    this.$router.go('0');
                });
        },
        
        handleClose(event) {
            event.preventDefault();
            this.$emit('handleCloseClick');
        }
    }
};
</script>
