<template>
    <div>
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>Password Settings</span>
            </div>
            <el-form ref="user_password" :model="user_password" :rules="rules.user_password" label-width="120px" label-position="top">
                <el-form-item label="Current Password" prop="current" required>
                    <el-input v-model="user_password.current" type="password" autocomplete="current-password"></el-input>
                </el-form-item>
                <el-form-item label="New Password" prop="new" required>
                    <el-input v-model="user_password.new" type="password" autocomplete="new-password"></el-input>
                </el-form-item>
                <el-form-item label="Confirm New Password" prop="new_confirm" required>
                    <el-input v-model="user_password.new_confirm" type="password" autocomplete="new-password"></el-input>
                </el-form-item>
            </el-form>

            <div class="clearfix d-flex justify-content-end">
                <el-button size="small" type="primary" @click="submitPassword">Save</el-button>
            </div>
        </el-card>
        <el-card class="box-card mt-4">
            <div slot="header" class="clearfix">
                API Tokens
            </div>
            <div>
                <el-input v-model="api_token.token" @keyup.enter.native="submitToken" placeholder="Enter a new token (20 min char.)"></el-input>
            </div>
            <el-table
                :data="tokenData"
                style="width: 100%">
                <el-table-column
                    prop="id"
                    label="#"
                    width="120">
                </el-table-column>
                <el-table-column
                    prop="token"
                    label="Token">
                    <template slot-scope="props">
                        <span>####################</span>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Options"
                    width="180">
                    <template slot-scope="props">
                        <el-button size="mini" type="danger" @click="deleteToken(props.row.id)"><i class="el-icon-delete"></i></el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
</template>

<script>
export default {
    name: "UserSettings",
    props: ['tokens'],
    data() {
        return {
            user_password: {
                current: null,
                new: null,
                new_confirm: null
            },
            api_token: {
                token: null
            },
            rules: {
                user_password: {
                    current: { required: true, message: 'Current password is required.', trigger: 'blur' },
                    new: { required: true, message: 'A new password is required.', trigger: 'blur' },
                    new_confirm: { required: true, message: 'You must confirm your new password.', trigger: 'blur' },
                }
            },
            tokenData: []
        }
    },
    mounted() {
        this.tokenData = this.tokens;
    },
    methods: {
        submitPassword() {
            this.$refs['user_password'].validate((valid) => {
                if(valid) {
                    axios.post('/api/user/password', {
                        current: this.user_password.current,
                        new: this.user_password.new,
                        new_confirm: this.user_password.new_confirm
                    }).then((res) => {
                        this.$message.success('Password Updated!');

                        this.user_password.current = '';
                        this.user_password.new = '';
                        this.user_password.new_confirm = '';
                    }).catch((e) => {
                        if(e.response.data.message) {
                            this.$message.error(e.response.data.message);
                        } else {
                            this.$message.error('There was an error changing your password.');
                        }
                        return console.log(e)
                    })
                }
            })
        },
        submitToken() {
            axios.post('/api/user/token', {
                token: this.api_token.token
            }).then((res) => {
                this.$message.success('Token saved.');
                this.getTokens()
                this.api_token.token = null;
            }).catch((e) => {
                console.log(e.response.data)
                if(e.response.data.message) {
                    this.$message.error(e.response.data.message);
                } else {
                    this.$message.error('There was an error submitting the token');
                }
                console.error(e);
            })
        },
        getTokens() {
            axios.get('/api/user/token')
                .then((res) => {
                    return this.tokenData = res.data;
                })
                .catch((e) => {
                    return console.error(e);
                })
        },
        deleteToken(id) {
            axios.delete('/api/user/token/' + id)
                .then((res) => {
                    this.getTokens();
                    return this.$message.success('Deleted the token');
                })
                .catch((e) => {
                    return console.error(e);
                })
        }
    }
}
</script>

