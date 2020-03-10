<template>
    <el-container>
        <el-aside style="width:auto;">
            <el-menu
                :collapse="collapse"
                default-active="1"
                class="sidebar"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b">
                <el-menu-item v-if="!m.children" v-for="(m, i) in menus" :index="(++i).toString()" :key="i" @click="$router.push(m.path)">
                    <font-awesome-icon :icon="m.icon" style="margin-right:5px;"></font-awesome-icon>
                    <span slot="title">{{m.label}}</span>
                </el-menu-item>
                <el-submenu v-else :index="(++i).toString()">
                    <template slot="title">
                        <font-awesome-icon :icon="m.icon" style="margin-right:5px;"></font-awesome-icon>
                        <span>{{m.label}}</span>
                    </template>
                    <el-menu-item v-for="(sm, ii) in m.children" :index="(i).toString() + '-' + ++ii" :key="ii" @click="$router.push(sm.path)">
                        <!-- <font-awesome-icon :icon="sm.icon" style="margin-right:5px;"></font-awesome-icon>  -->
                        <span slot="title">{{sm.label}}</span>
                    </el-menu-item>
                </el-submenu>
            </el-menu>
        </el-aside>
        <el-container>
            <el-header>
                <el-row>
                    <el-col :span="12">
                        <a href="#" @click.prevent="collapse = !collapse">
                            <font-awesome-icon :icon="collapse ? 'chevron-right' : 'chevron-left'" style="margin-right:15px;" size="2x"></font-awesome-icon>
                        </a>
                        <span class="title">
                            <!-- <img class="logo" src="../../assets/images/logo.png" alt=""> -->
                            Yayasan Qiblat
                        </span>
                    </el-col>
                    <el-col :span="12" class="navbar-right">
                        <span style="margin-right:10px;">Welcome, {{user.name}}!</span> |
                        <a style="margin-left:10px;" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </el-col>
                </el-row>
            </el-header>
            <el-main><router-view></router-view></el-main>
        </el-container>
    </el-container>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faHome, faUserLock, faChevronRight, faChevronLeft, faFile, faTags, faUsers, faMoneyCheck, faBoxes, faList, faMoneyBill, faMoneyBillAlt, faCogs, faDatabase, faImage, faChartBar, faMale, faFemale, } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
    faHome,
    faUserLock,
    faChevronRight,
    faChevronLeft,
    faFile,
    faTags,
    faUsers,
    faMoneyCheck,
    faMoneyBillAlt,
    faList,
    faCogs,
    faDatabase,
    faImage,
    faChartBar,
    faMale,
    faFemale
)

export default {
    name: 'App',
    components: { FontAwesomeIcon },
    data() {
        return {
            collapse: true,
            user: USER,
            menus: []
        }
    },
    methods: {
        getNavigation() {
            axios.get(BASE_URL + '/navigation')
                .then(r => this.menus = r.data)
                .catch(e => console.log(e))
        }
    },
    created() {
        this.getNavigation()
    }
}
</script>

<style scoped>
.sidebar {
    background-color: #545c64;
    border-color: #545c64;
    height: 100vh;
}

.sidebar:not(.el-menu--collapse) {
    width: 200px;
  }

.el-header {
    /* background-color: #545c64; */
    background-color: white;
    border-bottom: 1px solid #ddd;
    height: 60px;
    line-height: 60px;
}

img.logo {
    height: 40px;
    margin-right: 10px;
    vertical-align: middle;
}

.title {
    font-size: 24px;
    color: rgb(12, 162, 182);
    display: inline-block;
}

.navbar-right {
    text-align: right;
}

.el-main {
    height: 400px;
}

</style>
