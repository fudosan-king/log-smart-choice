<template>
    <div class="pagination justify-content-center">
        <nav>
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: paginationInfo.currentPage == 1 }">
                    <template v-if="paginationInfo.currentPage != 1">
                        <a
                            class="page-link"
                            href="javascript:void(0)"
                            tabindex="-1"
                            v-on:click="pageNumber(paginationInfo.currentPage - 1)"
                            >&lt;</a
                        >
                    </template>
                </li>
                <li class="page-item" v-if="paginationInfo.currentPage > 3">
                    <a class="page-link" href="javascript:void(0)" v-on:click="pageNumber(1, 'number', $event)">1</a>
                </li>
                <li v-if="paginationInfo.currentPage > 4" class="page-item disabled">
                    <span class="page-link">...</span>
                </li>

                <template v-for="number in paginationInfo.lastPage">
                    <template
                        v-if="number >= paginationInfo.currentPage - 2 && number <= paginationInfo.currentPage + 2"
                    >
                        <li
                            class="page-item"
                            :data-id="number"
                            :class="{ active: number == paginationInfo.currentPage }"
                        >
                            <a class="page-link" href="javascript:void(0)" v-on:click="pageNumber(number)"
                                >{{ number }}
                            </a>
                        </li>
                    </template>
                </template>
                <template v-if="paginationInfo.currentPage < paginationInfo.lastPage - 3">
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                </template>
                <li class="page-item" v-if="paginationInfo.currentPage < paginationInfo.lastPage - 2">
                    <a class="page-link" href="javascript:void(0)" v-on:click="pageNumber(paginationInfo.lastPage)">{{
                        paginationInfo.lastPage
                    }}</a>
                </li>
                <li class="page-item" :class="{ disabled: paginationInfo.currentPage == paginationInfo.lastPage }">
                    <template v-if="paginationInfo.currentPage != paginationInfo.lastPage">
                        <a
                            class="page-link"
                            href="javascript:void(0)"
                            v-on:click="pageNumber(paginationInfo.currentPage + 1)"
                            >&gt;</a
                        >
                    </template>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'Pagination',
    props: ['paginationInfo', 'pageChoice'],
    data() {
        return {};
    },
    methods: {
        pageNumber(page) {
            this.$emit('getListEstates', page);
        }
    }
};
</script>
