<template>
    <main>
        <div class="box_template">
            <section class="section_new_property p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title2 text-center">検索条件</h2>
                    </div>
                </div>
            </section>

            <section class="section_search_conditions bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form action="" class="frm_search_conditions">
                                <h2 class="little_title">エリアまたは沿線・駅から選択（複数選択可）</h2>
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a
                                            class="nav-link"
                                            :class="{ active: activeSearchTab == 'area' ? true : false }"
                                            id="pills-area-tab"
                                            data-toggle="pill"
                                            href="#pills-area"
                                            role="tab"
                                            aria-controls="pills-area"
                                            aria-selected="true"
                                            >エリアから探す</a
                                        >
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a
                                            class="nav-link"
                                            :class="{ active: activeSearchTab == 'station' ? true : false }"
                                            id="pills-station-tab"
                                            data-toggle="pill"
                                            href="#pills-station"
                                            role="tab"
                                            aria-controls="pills-station"
                                            aria-selected="false"
                                            >沿線・駅から探す</a
                                        >
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <!-- Areas Tab-->
                                    <div
                                        class="tab-pane fade show"
                                        :class="{ active: activeSearchTab == 'area' ? true : false }"
                                        id="pills-area"
                                        role="tabpanel"
                                        aria-labelledby="pills-area-tab"
                                    >
                                        <div class="row">
                                            <template v-for="district in districtList">
                                                <div class="col-6 col-lg-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            :id="'ck0' + district.id"
                                                            name="inputDistrict[]"
                                                            :value="district.name"
                                                        />
                                                        <label
                                                            class="custom-control-label"
                                                            :for="'ck0' + district.id"
                                                            >{{ district.name }}</label
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <p class="cases">
                                                        <span>{{ district.count_estates }}</span
                                                        >件
                                                    </p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <!-- End Areas Tab-->

                                    <!-- Station Tab-->
                                    <div
                                        class="tab-pane fade show"
                                        :class="{ active: activeSearchTab == 'station' ? true : false }"
                                        id="pills-station"
                                        role="tabpanel"
                                        aria-labelledby="pills-station-tab"
                                    >
                                        <template v-for="(stationParent, index) in stationParents">
                                            <h2 class="mb-0">{{ index }}</h2>
                                            <div class="accordion" :id="'accordionExample' + index">
                                                <template v-for="(station, indexStation) in stationParent">
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                            <h2 class="mb-0">
                                                                <div class="custom-control custom-checkbox ck_all">
                                                                    <input
                                                                        type="checkbox"
                                                                        class="custom-control-input"
                                                                        :id="'ck0' + index + indexStation"
                                                                        :value="'ck0' + index + indexStation"
                                                                    />
                                                                    <label
                                                                        class="custom-control-label"
                                                                        :for="'ck0' + index + indexStation"
                                                                        ><span>{{
                                                                            station.tran_company_short_name
                                                                        }}</span></label
                                                                    >
                                                                </div>
                                                                <button
                                                                    class="btn btn-link btn-block text-left collapsed"
                                                                    type="button"
                                                                    data-toggle="collapse"
                                                                    :data-target="'#collapseOne' + index + indexStation"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseOne"
                                                                ></button>
                                                            </h2>
                                                        </div>
                                                        <div
                                                            :id="'collapseOne' + index + indexStation"
                                                            class="collapse childStation"
                                                            aria-labelledby="headingOne"
                                                            :data-parent="'#accordionExample' + index"
                                                        >
                                                            <div
                                                                class="card-body"
                                                                :class="'ck0' + index + indexStation"
                                                            >
                                                                <div class="row">
                                                                    <template
                                                                        v-for="(child, indexChild) in station.child"
                                                                    >
                                                                        <div class="col-6 col-lg-6">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    :id="
                                                                                        'ck0' +
                                                                                            index +
                                                                                            indexStation +
                                                                                            indexChild
                                                                                    "
                                                                                    :value="child.name"
                                                                                    name="inputStation[]"
                                                                                    v-on:click="checkChange"
                                                                                />
                                                                                <label
                                                                                    class="custom-control-label"
                                                                                    :for="
                                                                                        'ck0' +
                                                                                            index +
                                                                                            indexStation +
                                                                                            indexChild
                                                                                    "
                                                                                    >{{ child.name }}</label
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 col-lg-6">
                                                                            <p class="cases"></p>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                    <!-- End Station Tab-->
                                </div>

                                <!--Price-->
                                <h2 class="little_title">価格（万円）</h2>
                                <div class="form-group box_form_group">
                                    <select class="custom-select" v-model="minTotalPrices" name="minTotalPrices">
                                        <template v-for="price in totalPrices">
                                            <option
                                                v-if="price != '上限なし'"
                                                :value="price"
                                                :selected="price == price ? 'selected' : ''"
                                                >{{ price }}</option
                                            >
                                        </template>
                                    </select>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxTotalPrices" name="maxTotalPrices">
                                        <template v-for="price in totalPrices">
                                            <option
                                                v-if="price != '下限なし'"
                                                :value="price"
                                                :selected="price == maxTotalPrices ? 'selected' : ''"
                                                >{{ price }}</option
                                            >
                                        </template>
                                    </select>
                                </div>
                                <!--End Price-->

                                <!--Square-->
                                <h2 class="little_title">広さ（m<sup>2</sup>）</h2>
                                <div class="form-group box_form_group">
                                    <select class="custom-select" v-model="minSquare" name="minSquare">
                                        <template v-for="square in squares">
                                            <option
                                                v-if="square != '上限なし'"
                                                :value="square"
                                                :selected="square == minSquare ? 'selected' : ''"
                                                >{{ square }}</option
                                            >
                                        </template>
                                    </select>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxSquare" name="maxSquare">
                                        <template v-for="square in squares">
                                            <option
                                                v-if="square != '下限なし'"
                                                :value="square"
                                                :selected="square == maxSquare ? 'selected' : ''"
                                                >{{ square }}</option
                                            >
                                        </template>
                                    </select>
                                </div>
                                <!--End Square-->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script>
export default {
    data() {
        let activeSearchTab = this.$getLocalStorage('tabActive') ? this.$getLocalStorage('tabActive') : 'area';
        return {
            districtList: {},
            stationParents: {},
            activeSearchTab: activeSearchTab,
            totalPrices: [],
            squares: [],
            checkedDistrictInput: [],
            minTotalPrices: '下限なし',
            maxTotalPrices: '上限なし',
            minSquare: '下限なし',
            maxSquare: '上限なし'
        };
    },
    updated() {
        let flagCheckAllChild = '';
        $('.ck_all input').click(function() {
            flagCheckAllChild = $(this).val();
            $('.' + flagCheckAllChild + ' input:checkbox')
                .not(this)
                .prop('checked', this.checked);
        });
    },
    mounted() {
        this.getDistrict();
        this.listTotalPrice();
        this.listSquare();
        this.getStationParents();
    },
    methods: {
        getDistrict() {
            this.$store.dispatch('getDistrict').then(response => {
                this.districtList = response.data;
            });
        },

        getStationParents() {
            this.$store.dispatch('getStationParents').then(response => {
                this.stationParents = response;
            });
        },

        listTotalPrice() {
            let min = 0;
            let max = 20000;
            let i = 0;
            while (min <= max) {
                if (i == 0) {
                    this.totalPrices.push('下限なし');
                } else if (min == max) {
                    this.totalPrices.push(min);
                    this.totalPrices.push('上限なし');
                } else {
                    this.totalPrices.push(min);
                }
                min = min + 1000;
                i++;
            }
        },

        listSquare() {
            let min = 0;
            let max = 150;
            let i = 0;
            while (min <= max) {
                if (i == 0) {
                    this.squares.push('下限なし');
                } else if (min == max) {
                    this.squares.push(min);
                    this.squares.push('上限なし');
                } else {
                    this.squares.push(min);
                }
                min = min + 10;
                i++;
            }
        },

        checkChange(event) {
            let child = event.target.id;
            let positionAllChild = $('#'+child).parentsUntil('.childStation');
            let childStation = $(positionAllChild[3]).attr('class').split(' ')[1];
            var totalCheckbox = $('.'+childStation+' input:checkbox').length;
            var totalChecked = $('.'+childStation+' input:checkbox :checked').length;
            // var totalCheckbox = document.querySelectorAll('.'+childStation).length;
            // var totalChecked = document.querySelectorAll('.'+childStation+' input:checkbox').length;
            console.log(totalCheckbox);
            console.log(totalChecked);
            // if (totalCheckbox == totalChecked) {
            //     $('input[name="inputStation[]"]').parent('.ck_all input').checked = true;
            // } else {
            //     $('input[name="inputStation[]"]').parent('.ck_all input').checked = false;
            // }
        }
    }
};
</script>
