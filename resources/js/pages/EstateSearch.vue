<template>
    <main>
        <div class="box_template">
            <section class="section_new_property p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title text-center">検索条件</h2>
                    </div>
                </div>
            </section>

            <section class="section_search_conditions bg-white pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form action="" class="frm_search_conditions">
                                <h2 class="little_title">
                                    エリアまたは沿線・駅から選択（複数選択可）
                                    <button class="burger" v-on:click="eventToggleBugger">
                                        <span class="burger_line"></span>
                                        <span class="burger_line"></span>
                                        <span class="burger_line"></span>
                                    </button>
                                </h2>
                                <div class="frm_search_conditions_content" style="display: none;">
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
                                                <template v-for="city in cityList">
                                                    <template v-for="district in city.districts">
                                                        <div class="col-6 col-lg-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    :id="'ck000' + district.id"
                                                                    name="inputDistrict[]"
                                                                    :value="district.name"
                                                                    :checked="
                                                                        conditionSearchBefore.districts
                                                                            ? conditionSearchBefore.districts.includes(
                                                                                  district.name
                                                                              )
                                                                            : ''
                                                                    "
                                                                />
                                                                <label
                                                                    class="custom-control-label"
                                                                    :for="'ck000' + district.id"
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
                                            <div class="accordion" id="accordionExample">
                                                <!-- <template v-for="(stationParent, index) in stationParents">
                                                    <h2>{{ index }}
                                                        <a :href="'#box_jr'+ index" data-toggle="collapse" class="" aria-expanded="false">
                                                            <div class="icon plus-to-minus"></div>
                                                        </a>
                                                    </h2> -->
                                                <template v-for="(transport, indexTransport) in transports">
                                                    <div class="multi-collapse" :id="'box_jr' + indexTransport">
                                                        <div class="card">
                                                            <div
                                                                class="card-header"
                                                                :id="'headingOne' + indexTransport"
                                                            >
                                                                <h2 class="mb-0">
                                                                    <div class="custom-control custom-checkbox ck_all">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="custom-control-input"
                                                                            :id="'ck0' + indexTransport"
                                                                            :value="'ck0' + indexTransport"
                                                                            :checked="
                                                                                stationParentBefore
                                                                                    ? stationParentBefore.includes(
                                                                                          'ck0' + indexTransport
                                                                                      )
                                                                                    : ''
                                                                            "
                                                                        />
                                                                        <label
                                                                            class="custom-control-label"
                                                                            :for="'ck0' + indexTransport"
                                                                            ><span>{{ transport.name }}</span></label
                                                                        >
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-link btn-block text-left collapsed"
                                                                        type="button"
                                                                        data-toggle="collapse"
                                                                        :data-target="'#collapseOne' + indexTransport"
                                                                        aria-expanded="false"
                                                                        :aria-controls="'collapseOne' + indexTransport"
                                                                    ></button>
                                                                </h2>
                                                            </div>
                                                            <div
                                                                :id="'collapseOne' + indexTransport"
                                                                class="collapse station"
                                                                :aria-labelledby="'headingOne' + indexTransport"
                                                                :data-parent="'#collapseOne' + indexTransport"
                                                            >
                                                                <div class="card-body" :class="'ck0' + indexTransport">
                                                                    <div class="row">
                                                                        <template
                                                                            v-for="(station, indexStation) in transport[
                                                                                'stations'
                                                                            ]"
                                                                        >
                                                                            <div class="col-6 col-lg-6">
                                                                                <div
                                                                                    class="custom-control custom-checkbox"
                                                                                >
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        :id="
                                                                                            'ck0' +
                                                                                                station.name +
                                                                                                indexStation +
                                                                                                station.transport_id
                                                                                        "
                                                                                        :value="station.name"
                                                                                        name="inputStation[]"
                                                                                        v-on:click="checkChange"
                                                                                        :data-transport="
                                                                                            station.transport_id
                                                                                        "
                                                                                        :checked="
                                                                                            conditionSearchBefore.stations
                                                                                                ? conditionSearchBefore.stations.filter(
                                                                                                      e =>
                                                                                                          e.name ===
                                                                                                          station.name
                                                                                                  ).length > 0 &&
                                                                                                  conditionSearchBefore.stations.filter(
                                                                                                      e =>
                                                                                                          e.transportId ==
                                                                                                          transport.id
                                                                                                  ).length > 0
                                                                                                : ''
                                                                                        "
                                                                                    />
                                                                                    <label
                                                                                        class="custom-control-label"
                                                                                        :for="
                                                                                            'ck0' +
                                                                                                station.name +
                                                                                                indexStation +
                                                                                                station.transport_id
                                                                                        "
                                                                                        >{{ station.name }}</label
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
                                                    </div>
                                                </template>

                                                <!-- </template> -->
                                            </div>
                                        </div>
                                        <!-- End Station Tab-->
                                    </div>
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
                                            <option v-if="square != '上限なし'" :value="square">{{ square }}</option>
                                        </template>
                                    </select>
                                    <p class="mb-0">⁓</p>
                                    <select class="custom-select" v-model="maxSquare" name="maxSquare">
                                        <template v-for="square in squares">
                                            <option v-if="square != '下限なし'" :value="square">{{ square }}</option>
                                        </template>
                                    </select>
                                </div>
                                <!--End Square-->

                                <!--Tab Search-->
                                <h2 class="little_title">こだわり</h2>
                                <ul class="list_commitment">
                                    <li v-for="tab in tabList">
                                        <a
                                            class="btn_commitment"
                                            v-on:click="eventToggleTab"
                                            :class="{ actived: tabListActived.includes(tab.id) ? true : false }"
                                            href="javascript:void(0)"
                                            :data-id="tab.id"
                                            :data-value="tab.name"
                                            >{{ tab.name }}</a
                                        >
                                    </li>
                                </ul>
                                <!--End Tab Search-->
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
        let conditionSearch = this.$getLocalStorage('conditionSearch')
            ? JSON.parse(this.$getLocalStorage('conditionSearch'))
            : [];
        let stations = this.$getLocalStorage('parentStations')
            ? JSON.parse(this.$getLocalStorage('parentStations'))
            : [];
        let minPrice = conditionSearch.price ? conditionSearch.price.min : '下限なし';
        let maxPrice = conditionSearch.price ? conditionSearch.price.max : '上限なし';
        let minSquare = conditionSearch.square ? conditionSearch.square.min : '下限なし';
        let maxSquare = conditionSearch.square ? conditionSearch.square.max : '上限なし';
        let tabListActived = conditionSearch.tabSesarch ? conditionSearch.tabSesarch : [];

        return {
            cityList: {},
            transports: {},
            activeSearchTab: activeSearchTab,
            totalPrices: [],
            squares: [],
            checkedDistrictInput: [],
            minTotalPrices: minPrice,
            maxTotalPrices: maxPrice,
            minSquare: minSquare,
            maxSquare: maxSquare,
            conditionSearchBefore: conditionSearch,
            stationParentBefore: stations,
            tabList: [],
            tabListActived: tabListActived
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

        // const burger = document.querySelector(".burger");

        // burger.addEventListener("click", function () {
        //     const body = document.body;
        //     body.classList.toggle("nav_open");
        // });

        $('.plus-to-minus').click(function(event) {
            $(this).toggleClass('minus');
        });
    },
    mounted() {
        this.getCities();
        this.listTotalPrice();
        this.listSquare();
        this.getTransports();
        this.getTabList();
    },
    methods: {
        getCities() {
            this.$store.dispatch('getCityList').then(response => {
                this.cityList = response.data;
            });
        },

        getTransports() {
            this.$store.dispatch('getTransportList').then(response => {
                this.transports = response.data;
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

        getTabList() {
            this.$store.dispatch('getTabList').then(response => {
                this.tabList = response;
            });
        },

        checkChange(event) {
            let child = event.target.id;
            let positionAllChild = $('#' + child).parentsUntil('.station');
            let station = $(positionAllChild[3])
                .attr('class')
                .split(' ')[1];
            var totalCheckbox = $('.' + station + ' input:checkbox').length;
            var totalChecked = $('.' + station + ' [name="inputStation[]"]:checked').length;
            let eleParent = $('#' + station);
            if (totalCheckbox == totalChecked) {
                eleParent.prop('checked', true);
            } else {
                eleParent.prop('checked', false);
            }
        },

        eventToggleTab(event) {
            $(event.target).toggleClass('actived');
        },

        eventToggleBugger(event) {
            event.preventDefault();
            $('.frm_search_conditions_content').slideToggle('fast');
        }
    }
};
</script>
