<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Show Images</span>
        </div>

        <el-table
            v-loading="true"
            :data="images"
            class="w-100 show-images-table"
        >
            <el-table-column
                prop="id"
                label="#"
                width="50"
            >
            </el-table-column>

            <el-table-column
                prop="slug"
                label="Slug"
            >
            </el-table-column>

            <el-table-column
                label="Actions"
                width="200"
            >
                <template slot-scope="props">
                    <el-row>
                        <el-button size="small" icon="el-icon-search"></el-button>
                        <el-button v-if="!props.row.active" size="small" type="success" icon="el-icon-circle-plus-outline"></el-button>
                        <el-button size="small" type="danger" icon="el-icon-delete"></el-button>
                    </el-row>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
import axios from 'axios';

export default {
    name: "ShowImagesTable",
    data: () => {
        return {
            images: []
        }
    },
    mounted() {
        this.getImages();
    },
    methods: {
        getImages() {
            axios.get('/api/show-image')
                .then((res) => {
                    console.log(res.data)
                })
                .catch((err) => {
                    console.log(err.data)
                });
        }
    }
}
</script>
