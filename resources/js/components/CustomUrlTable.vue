<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Custom Urls</span>
        </div>

        <el-table
            v-loading="loading"
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
                prop="image.slug"
                label="Image"
                width="100"
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
                        <a :href="props.row.image.url">
                            <el-button size="small" icon="el-icon-search"></el-button>
                        </a>
                        <el-button size="small" type="danger" icon="el-icon-delete" @click="deleteImage(props.row)"></el-button>
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
            images: [],
            loading: true,
        }
    },
    mounted() {
        this.getImages();

        console.log(this.images);
        this.$root.$on('image_added', (data) => {
            this.getImages();
        })
    },
    methods: {
        getImages() {
            axios.get('/api/custom-images')
                .then((res) => {
                    this.images = res.data.data;
                    this.loading = false;
                    console.log(res.data.data)
                })
                .catch((err) => {
                    console.log(err.data)
                });
        },
        deleteImage(image) {
            axios.delete('/api/custom-images/' + image.id)
                .then((res) => {
                    this.images.splice(image, 1);
                    this.$message.success('URL was deleted');
                })
                .catch((err) => {
                    this.$message.error('There was an error deleting the URL');
                })
        }
    }
}
</script>
