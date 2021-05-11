<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Backups</span>
        </div>

        <el-table
            :data="backups"
            class="w-100 show-images-table"
        >
            <el-table-column
                prop="id"
                label="#"
                width="50"
            >
            </el-table-column>

            <el-table-column
                prop="dir"
                label="Image"
            >
            </el-table-column>

            <el-table-column
                prop="created_at"
                label="Created"
                width="120"
            >
                <template slot-scope="prop">
                    {{ formatDate(prop.row.created_at) }}
                </template>
            </el-table-column>

            <el-table-column
                label="Actions"
                width="200"
            >
                <template slot-scope="props">
                    <el-row>
                        <a :href="'/backups/' + props.row.id" target="_blank">
                            <el-button size="small" type="success" icon="el-icon-download"></el-button>
                        </a>
                    </el-row>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
import moment from 'moment-timezone';

export default {
    name: "BackupsTable",
    props: ['backups'],
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM HH:mm')
        }
    }
}
</script>
