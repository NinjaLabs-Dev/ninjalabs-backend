<template>
    <div>
        <el-form ref="form" label-width="120px">
            <el-upload
                class="avatar-uploader"
                action="/api/image-upload"
                :headers="{ 'X-CSRF-TOKEN': csrf}"
                :show-file-list="false"
                :on-success="handleUploadSuccess"
                :on-error="handleAvatarError">
                <el-button type="primary" size="medium" disabled>
                    Upload
                </el-button>
            </el-upload>
        </el-form>

    </div>
</template>

<script>
export default {
    name: "DashboardButtonControls",
    props: ['csrf'],
    methods: {
        handleUploadSuccess: function() {
            this.$message.success('Image Uploaded');
        },
        handleAvatarError: function() {
            this.$message.error('Image Not Uploaded');
        }
    }
}
</script>
