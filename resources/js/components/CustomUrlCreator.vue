<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Create Custom Url</span>
        </div>

        <el-form :inline="true" :rules="rules" ref="custom_form" :model="customurl">
            <el-row>
                <el-form-item label="Route Image" prop="route_image">
                    <el-select
                        v-model="customurl.route_image"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="abc12"
                        :remote-method="imageList"
                        :loading="loading">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Custom URI" prop="uri">
                    <el-input
                        v-model="customurl.uri"
                        placeholder="image123"
                    ></el-input>
                </el-form-item>
            </el-row>
            <el-row class="d-flex justify-content-end">
                <el-form-item>
                    <el-button type="primary" @click="submitForm()">Create</el-button>
                </el-form-item>
            </el-row>
        </el-form>
    </el-card>
</template>

<script>
import axios from "axios";

export default {
    name: "CustomUrlCreator",
    props: [ 'images' ],
    data: () => {
        return {
            list: [],
            loading: false,
            options: [],
            customurl: {
                route_image: '',
                uri: ''
            },
            rules: {
                route_image: [
                    { required: true, message: 'Route image is required.', trigger: 'blur' }
                ],
                uri: [
                    { required: true, message: 'URI is required.', trigger: 'blur' }
                ]
            }
        }
    },
    mounted() {
        this.list = this.images.map(item => {
            console.log(item)
            return {
                value: item.id,
                label: item.slug
            }
        });

        console.log(this.list);
    },
    methods: {
        imageList: function(q) {
            if(q !== '') {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.options = this.list.filter((item) => {
                        return item.label.toLowerCase().indexOf(q.toLowerCase()) > -1;
                    })
                }, 200);
            }  else {
                this.options = [];
            }
        },
        submitForm: function () {
            this.$refs['custom_form'].validate((valid) => {
                if(valid) {
                    axios.post('/api/custom-images', {
                        route_image: this.customurl.route_image,
                        uri: this.customurl.uri
                    }).then((res) => {
                        this.$root.$emit('image_added', res.data.data);
                        this.customurl.route_image = '';
                        this.customurl.uri = '';
                        this.$message.success('Custom URL Created.');
                    }).catch(() => {
                        this.$message.error('There was an error creating the URL.');
                    })
                }
            })
        }
    }
}
</script>

<style>
    .show-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .show-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .show-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .show-image {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
