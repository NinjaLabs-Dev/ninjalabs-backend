<template>
    <el-card class="box-card">
        <div slot="header" class="d-flex align-items-center justify-content-between">
            <div>
                <h3>Overview</h3>
            </div>
            <el-button class="px-2" style="float: right" type="primary" size="small" icon="el-icon-plus" @click="addServer">Add Server</el-button>
        </div>

        <el-card class="box-card servers cursor-pointer" v-for="server in servers" :key="server.id" v-if="servers.length" :body-style="{padding: openServer === server.id ? '20px' : '0'}">
            <div slot="header" class="d-flex justify-content-between align-items-center">
                <h4>{{ server.name }} - <span class="opacity-50">{{ server.ip }}</span></h4>
                <div class="d-flex justify-content-center align-items-center">
                    <el-tooltip :content="convertUptime(server.stat.uptime, true)" placement="top">
                        <span class="opacity-50 mr-2">Uptime: {{ convertUptime(server.stat.uptime) }}</span>
                    </el-tooltip>
                    <el-tooltip :content="warningText(server.stat.uptime)" placement="top">
                        <div :class="'status ' + warningCheck(server.stat.uptime)"></div>
                    </el-tooltip>

                    <i class='bx bx-chevron-up ml-2 dropdown-arrow cursor-pointer' @click="triggerServer(server.id)" v-if="openServer !== server.id"></i>
                    <i class='bx bx-chevron-down ml-2 dropdown-arrow cursor-pointer' @click="openServer = null" v-if="openServer === server.id"></i>
                </div>
            </div>

            <div class="server-overview" v-if="openServer === server.id">
                <div class="row basic mx-0">
                    <div class="col-xl-6 pl-0">
                        <el-card class="box-card">
                            <div>
                                <p class="info"><span class="label">Server IP:</span> {{ server.ip }}</p>
                                <p class="info"><span class="label">SSH Connections:</span> {{ server.stat.ssh_connections ? server.stat.ssh_connections : '0' }}</p>
                                <p class="info"><span class="label">Uptime:</span> {{ convertUptime(server.stat.uptime) }}</p>
                            </div>
                        </el-card>
                    </div>
                    <div class="col-xl-6 pr-0">
                        <el-card class="box-card">
                            <div class="head mb-2">
                                <span class="info"><span class="label">Tracked Github Repositories:</span></span>
                            </div>

                            <div class="github-repos">
                                <div v-for="(repo, id) in server.repos" :key="id" class="d-flex">
                                    <el-input :value="repo.name" class="mr-2" disabled></el-input>
                                    <el-button icon="el-icon-delete" @click="removeGithub(id)"></el-button>
                                </div>

                                <div class="new d-flex flex-column  mt-4">
                                    <el-card class="box-card shadow-none">
                                        <el-input class="mr-2" placeholder="NinjaLabs-Dev/test" size="small" v-model="githubForm.name"></el-input>
                                        <div class="d-flex flex-row my-2">
                                            <el-input class="mr-2" placeholder="Main" size="small" v-model="githubForm.branch"></el-input>
                                            <el-input class="mr-2" placeholder="Token" size="small" v-model="githubForm.token"></el-input>
                                            <el-button type="success" size="small" icon="el-icon-plus" @click="addGithub(server.id)"></el-button>
                                        </div>
                                    </el-card>
                                </div>
                            </div>
                        </el-card>
                    </div>
                </div>
                <div class="server-data mt-4">
                    <el-card class="box-card chart" :body-style="{padding: '0'}">
                    <span class="chart-number">
                        <span class="label">CPU</span>
                        <span class="data">{{ chartData[server.id].cpu[0].data[chartData[server.id].cpu[0].data.length - 1] }}%</span>
                    </span>
                        <apexchart height="150" :options="chartSettings('palette10', chartTime[server.id])" :series="chartData[server.id].cpu"></apexchart>
                    </el-card>

                    <el-card class="box-card chart" :body-style="{padding: '0'}">
                    <span class="chart-number">
                        <span class="label">RAM</span>
                        <span class="data">{{ chartData[server.id].ram[0].data[chartData[server.id].ram[0].data.length - 1] }}%</span>
                    </span>
                        <apexchart height="150" :options="chartSettings('palette1', chartTime[server.id])" :series="chartData[server.id].ram"></apexchart>
                    </el-card>

                    <el-card class="box-card chart" :body-style="{padding: '0'}">
                    <span class="chart-number">
                        <span class="label">Network</span>
                        <span class="data">{{ chartData[server.id].net[0].data[chartData[server.id].net[0].data.length - 1] }}MB &#8593; {{ chartData[server.id].net[1].data[chartData[server.id].net[1].data.length - 1] }}MB &#8595;</span>
                    </span>
                        <apexchart height="150" :options="chartSettings('palette5', chartTime[server.id])" :series="chartData[server.id].net"></apexchart>
                    </el-card>

                    <el-card class="box-card chart" :body-style="{padding: '0', display: 'flex', 'justify-content': 'space-between', 'flex-direction': 'column', height: '100%'}">
                    <span class="chart-number">
                        <span class="label">Storage</span>
                        <span class="data">{{ chartData[server.id].storage[0] }}%</span>
                    </span>
                        <apexchart height="250" :options="chartSettings('palette8', ['Storage'], 'radial')" :series="chartData[server.id].storage"></apexchart>
                    </el-card>
                </div>
            </div>
        </el-card>

        <el-card class="box-card text-center" v-if="!servers.length">
            No servers currently configured! 👨‍🔬
        </el-card>

        <el-dialog
            title="Create Server"
            :visible.sync="serverVisible"
        >
            <el-form :model="serverForm" :rules="serverRules" ref="serverForm" label-width="120px" label-position="top">
                <el-form-item label="Server Name" prop="name" required>
                    <el-input v-model="serverForm.name"></el-input>
                </el-form-item>
                <el-form-item label="Server IP" prop="ip" required>
                    <el-input v-model="serverForm.ip"></el-input>
                </el-form-item>
                <el-form-item label="Server Url" prop="url" required>
                    <el-input v-model="serverForm.url"></el-input>
                </el-form-item>
                <el-form-item label="Auth Token" prop="token" required>
                    <el-input v-model="serverForm.token"></el-input>
                </el-form-item>
                <el-form-item class="d-flex justify-content-end">
                    <el-button @click="resetServer">Cancel</el-button>
                    <el-button type="primary" @click="submitServer">Create</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </el-card>
</template>

<script>
import axios from 'axios';
import moment from 'moment-timezone';
import VueApexCharts from 'vue-apexcharts';

export default {
    name: "ServersTable",
    props: ['servers'],
    mounted() {
      this.serverData = this.servers;
    },
    data() {
        return {
            serverData: [],
            openServer: 0,
            serverVisible: false,
            serverForm: {
                name: '',
                ip: '',
                token: ''
            },
            githubForm: {
                name: null,
                branch: null,
                token: null
            },
            serverRules: {
                name: [
                    { required: true, message: 'Please input a name', trigger: 'blur' }
                ],
                ip: [
                    { required: true, message: 'Please input an ip', trigger: 'blur' }
                ],
                url: [
                    { required: true, message: 'Please input a url', trigger: 'blur' }
                ],
                token: [
                    { required: true, message: 'Please input a token', trigger: 'blur' }
                ]
            },
            chartTime: {},
            chartData: {}
        }
    },
    methods: {
        addServer: function() {
            this.serverVisible = true;
        },
        resetServer: function () {
            this.serverVisible = false;
            this.serverForm.name = '';
            this.serverForm.ip = '';
            this.serverForm.token = '';
        },
        triggerServer: async function(server_id) {
            await axios.get(`/api/server-stats/${server_id}`)
                .then((res) => {
                    let stats = this.defaultData();

                    stats.cpu[0].data = res.data.stats.cpu;
                    stats.ram[0].data = res.data.stats.ram;
                    stats.net[0].data = res.data.stats.network_out;
                    stats.net[1].data = res.data.stats.network_in;
                    stats.storage = res.data.stats.storage;

                    this.chartData[server_id] = stats;
                    this.chartTime[server_id] = res.data.time;

                    console.log(this.chartData[server_id])
                }).catch(() => {
                    return this.$message.error('There was an error getting data')
                })

            this.openServer = server_id;
        },
        getServers: function() {
            axios.get('/api/server-stats')
                .then((res) => {
                    this.serverData = res.data;
                })
        },
        submitServer: function () {
            this.$refs['serverForm'].validate((valid) => {
                if(valid) {
                    axios.post('/api/server-stats', {
                        name: this.serverForm.name,
                        ip: this.serverForm.ip,
                        url: this.serverForm.url,
                        token: this.serverForm.token
                    }).then((res) => {
                        if(res.data.error) {
                            return this.$message.error(res.data.message);
                        }

                        this.resetServer();
                        this.getServers();
                        return this.$message.success('Created server');
                    }).catch(() => {
                        return this.$message.error('There was an error!');
                    })
                }
            })
        },
        addGithub: function(server_id) {
            if(this.githubForm.name === null) return;

            axios.post(`/api/server-stats/${server_id}/github`, {
                name: this.githubForm.name,
                branch: this.githubForm.branch,
                token: this.githubForm.token
            }).then((res) => {
                if(res.data.error) return this.$message.error(res.data.message);

                return this.$message.success('Added github tracking');
            }).catch((err) => {
                return this.$message.error('There was an error adding the github tracking')
            })
        },
        removeGithub: function(server_id, id) {
            axios.delete(`/api/server-stats/${server_id}/github/${id}`)
                .then((res) => {
                    if(res.data.error) return this.$message.error(res.data.message);

                    return this.$message.success('Deleted github tracking');
                }).catch((err) => {
                    return this.$message.error('There was an error adding the github tracking')
                })
        },
        chartSettings: function(palette, categories, type = null) {
            let options = this.defaultSettings(type);
            options.theme.palette = palette;
            options.xaxis.categories = categories;

            return options;
        },
        convertUptime: function(uptime, full = false) {
            let time = moment().subtract(uptime, 'seconds');

            if(full) {
                return time.format('DD/mm/yyyy HH:mm:ss')
            }

            return time.fromNow()
        },
        warningCheck: function(uptime) {
             let time = moment().diff(moment().subtract(uptime, 'seconds'), 'hours');

            if(time === 0) return 'red';

            if(time > 24) {
                return 'green'
            } else if(time > 0 && time < 24) {
                return 'warning'
            }
        },
        warningText: function(uptime) {
            switch (this.warningCheck(uptime)) {
                case 'red':
                    return 'Offline';
                case 'warning':
                    return 'System Online - Monitoring Required'
                case 'green':
                    return 'System Operational'
            }
        },
        defaultData: function() {
            return {
                cpu: [{
                    name: 'CPU',
                    data: []
                }],
                ram: [{
                    name: 'RAM',
                    data: []
                }],
                net: [
                    {
                        name: 'Upload',
                        data: []
                    },
                    {
                        name: 'Download',
                        data: []
                    }
                ],
                storage: []
            }
        },
        defaultSettings: function(type) {
            switch (type) {
                case 'radial':
                    return {
                        chart: {
                            type: 'radialBar',
                            sparkline: {
                                enabled: true
                            },
                            toolbar: {
                                show: false
                            },
                            zoom: {
                                enabled: false
                            },
                            animations: {
                                speed: 6000
                            }
                        },
                        theme: {
                            palette: 'palette1',
                        },
                        dataLabels: {
                            show: false,
                            name: {
                                show: false
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            lineCap: 'round'
                        },
                        legend: {
                            show: false
                        },
                        plotOptions: {
                            radialBar: {
                                startAngle: -90,
                                endAngle: 90,
                                track: {
                                    startAngle: -90,
                                    endAngle: 90
                                },
                                hollow: {
                                    margin: 15,
                                    size: "55%"
                                },
                                dataLabels: {
                                    name: {
                                        show: false
                                    },
                                    value: {
                                        show: false
                                    }
                                }
                            }
                        },
                        grid: {
                            show: false,
                            xaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            }
                        },
                        tooltip: {
                            enabled: false
                        },
                        yaxis: {
                            labels: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                        },
                        xaxis: {
                            labels: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                        }
                    }
                default: {
                    return {
                        chart: {
                            type: 'area',
                            sparkline: {
                                enabled: true
                            },
                            toolbar: {
                                show: false
                            },
                            zoom: {
                                enabled: false
                            }
                        },
                        theme: {
                            palette: 'palette1',
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        legend: {
                            show: false
                        },
                        grid: {
                            show: false,
                            xaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            }
                        },
                        tooltip: {
                            enabled: true
                        },
                        yaxis: {
                            labels: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                        },
                        xaxis: {
                            labels: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                        },
                    }
                }
            }
        }
    },
    components: {
        'apexchart': VueApexCharts
    }
}
</script>

<style scoped lang="scss">
.status {
    width: 16px;
    height: 16px;
    border-radius: 16px;
}

.red {
    background-color: #c13838;
}

.green {
    background-color: #38c172;
}

.warning {
    background-color: #f3bb35;
}

.gray {
    background-color: #585858;
}

.dropdown-arrow {
    font-size: 2em;
}

.chart .chart-number {
    display: flex;
    justify-content: space-between;
    color: #0080de;
    font-size: 1em;
    font-family: 'Atkinson Hyperlegible', sans-serif;
    margin-bottom: 1em;
    padding: 20px;
}

.chart .chart-number .label {
    text-transform: uppercase;
}

.server-overview {
    display: flex;
    flex-direction: column;
}

.server-overview .server-data {
    display: flex;
    justify-content: space-between;
}

.server-overview .box-card {
    margin: 0;
}

.server-overview .basic {
    display: flex;
    justify-content: space-around;
    width: 100%;
}

.server-overview .info .label {
    font-weight: 600;
}

.server-overview .info {
    margin-bottom: 0.5em;
}
</style>
