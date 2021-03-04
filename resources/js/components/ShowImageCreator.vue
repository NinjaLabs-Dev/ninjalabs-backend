<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Create New Show</span>
        </div>

        <el-form :inline="true" :rules="rules" ref="show_form" :model="show">
            <el-row>
                <el-form-item label="Show time" required>
                    <el-col :span="11">
                        <el-form-item prop="date" class="mx-0">
                            <el-date-picker type="date" placeholder="Pick a date" v-model="show.date" class="w-100"></el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col class="line text-center" :span="2">-</el-col>
                    <el-col :span="11">
                        <el-form-item prop="time">
                            <el-time-select
                                prop="start"
                                placeholder="Pick a time"
                                v-model="show.time"
                                class="w-100"
                                required
                                :picker-options="{
                                    step: '01:00',
                                    start: '00:00',
                                    end: '24:00',
                                }">
                            </el-time-select>
                        </el-form-item>
                    </el-col>
                </el-form-item>
            </el-row>
            <el-row>
                <el-form-item label="Show Image" prop="image">
                    <el-upload
                        class="show-uploader"
                        action="/api/show-image/"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                        <img v-if="show.image" :src="show.image" class="show-image">
                        <i v-else class="el-icon-plus show-uploader-icon"></i>
                    </el-upload>
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
export default {
    name: "ShowImageCreator",
    data: () => {
        return {
            show: {
                image: '',
                date: '',
                time: ''
            },
            rules: {
                time: [
                    { required: true, message: 'Please select a show date', trigger: 'blur' }
                ],
                date: [
                    { required: true, message: 'Please select a show date', trigger: 'blur' }
                ],
                image: [
                    { required: true, message: 'Please upload a show image', trigger: 'change' }
                ]
            }
        }
    },
    methods: {
        handleAvatarSuccess(res, file) {
            this.show.image = URL.createObjectURL(file.raw);
        },
        beforeAvatarUpload(file) {
            const isIamge = file.type.split('/')[0] === 'image';

            if(!isIamge) {
                this.$message.error('File must be an image!');
            }

            return isIamge;
        },
        submitForm() {
            this.$refs['show_form'].validate((valid) => {
                if(valid) {
                    console.log("Sent!");
                } else {
                    console.log("error!");
                    return false;
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
