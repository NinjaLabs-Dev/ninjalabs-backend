<template>
    <ul class="infinite-list" v-infinite-scroll="load" style="overflow:auto; height: 400px">
        <li v-for="i in data.data" class="infinite-list-item">{{ i }}</li>
    </ul>
</template>

<script>
import elTableInfiniteScroll from 'el-table-infinite-scroll';
import axios from 'axios';

export default {
    name: "ImageViewer",
    args: ['data'],
    directive: {
        'el-table-infinite-scroll': elTableInfiniteScroll
    },
    data() {
        return {
        }
    },
    methods: {
        load() {
            if(this.data === this.tableData.last_page) return;
            this.page += 1;

            axios.get('api/images?page=' + this.page, {
                headers : {
                    'Content-Type': 'application/json',
                    'id': 1,
                    'token': 'abc123'
                }
            })
                .then((res) => {
                    this.tableData.data.push(res.data.data)
                });
        }
    },
    mounted() {

    },
}
</script>

<style scoped lang="scss">
    .el-table tr {
        background: rgba(31, 41, 55, 1);
    }
</style>
