<template>
    <el-menu :default-active="activeIndex" class="el-menu" mode="horizontal">
        <el-menu-item index="1">
            <a href="/">Home</a>
        </el-menu-item>
        <el-menu-item index="2">
            <a href="/customs">Custom URLs</a>
        </el-menu-item>
        <el-menu-item index="3" v-if="isadmin">
            <a href="/backups">DB Backups</a>
        </el-menu-item>
        <el-submenu index="4">
            <template slot="title">{{ user.name }}</template>
            <el-menu-item index="4-1">
                <a href="/user/settings">Settings</a>
            </el-menu-item>
            <div class="line"></div>
            <el-menu-item index="4-3">
                <a href="/logout">Logout</a>
            </el-menu-item>
        </el-submenu>
    </el-menu>
</template>

<script>
export default {
    name: "NavbarOptions",
    props: ['isadmin', 'user'],
    data() {
        return {
            activeIndex: '1',
            routes: [
                {
                    path: '/',
                    index: '1'
                }, {
                    path: '/customs',
                    index: '2'
                }, {
                    path: '/backups',
                    index: '3'
                }, {
                    path: '/user/settings',
                    index: '4'
                }, {
                    path: '/user/api-tokens',
                    index: '4'
                }
            ]
        }
    },
    mounted() {
        this.routes.forEach((route) => {
           if(route.path === document.location.pathname) {
               this.activeIndex = route.index;
           }
        });
    }
}
</script>
