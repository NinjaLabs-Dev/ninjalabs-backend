<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Custom Urls</span>
        </div>

        <el-table
            v-loading="loading"
            :data="users"
            class="w-100 show-images-table"
        >
            <el-table-column
                prop="id"
                label="#"
                width="50"
            >
            </el-table-column>

            <el-table-column
                prop="username"
                label="Username"
                width="100"
            >
            </el-table-column>
            <el-table-column
                label="Icons"
                width="100"
            >
            </el-table-column>

            <el-table-column
                prop="footer"
                label="Slug"
            >
            </el-table-column>

            <el-table-column
                label="Actions"
                width="200"
            >
                <template slot-scope="props">
                    <el-row>
                        <el-button size="small" type="danger" icon="el-icon-delete" @click="deleteUser(props.row)"></el-button>
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
            users: [],
            loading: true,
        }
    },
    mounted() {
        this.getImages();

        console.log(this.users);
        this.$root.$on('image_added', (data) => {
            this.getImages();
        })
    },
    methods: {
        getImages() {
            axios.get('/api/twitch-users')
                .then((res) => {
                    this.users = res.data.data;
                    this.loading = false;
                    console.log(res.data.data)
                })
                .catch((err) => {
                    console.log(err.data)
                });
        },
        deleteUser(user) {
            axios.delete('/api/twitch-users' + user.id)
                .then((res) => {
                    this.users.splice(user, 1);
                    this.$message.success('URL was deleted');
                })
                .catch((err) => {
                    this.$message.error('There was an error deleting the URL');
                })
        }
    }
}
</script>
