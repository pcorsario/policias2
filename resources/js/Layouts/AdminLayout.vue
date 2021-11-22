<template>
    <div>
        <el-container class="h-screen">
            <el-container>
                <el-aside width="250px" class="sidebar-container h-full hidden md:block">
                    <el-menu id="aside-menu" :default-openeds="['1']">
                        <el-submenu index="1" v-if="isAdmin">
                            <template #title><i class="el-icon-user"></i> Delegados</template>
                            <inertia-link :href="route('policia.index')">
                                <el-menu-item index="1-1">
                                    Gestionar delegados
                                </el-menu-item>
                            </inertia-link>
                            <inertia-link :href="route('rango.index')">
                                <el-menu-item index="1-3">
                                    Gestionar grados
                                </el-menu-item>
                            </inertia-link>
                        </el-submenu>
                        <el-submenu index="2">
                            <template #title><i class="el-icon-menu"></i>Evento</template>
                            <el-menu-item-group>
                                <inertia-link :href="route('cuadrante.index')" v-if="isAdmin">
                                    <el-menu-item index="2-1">
                                        Gestion de cuadrantes
                                    </el-menu-item>
                                </inertia-link>
                                <inertia-link :href="route('invitacion.index')" v-if="isAdmin">
                                    <el-menu-item index="2-2">
                                        Invitaciones
                                    </el-menu-item>
                                </inertia-link>

                                <inertia-link :href="route('invitacion.escanear')">
                                    <el-menu-item index="2-3">
                                        Escanear
                                    </el-menu-item>
                                </inertia-link>

                            </el-menu-item-group>
                        </el-submenu>
                        <el-submenu index="3" v-if="isAdmin">
                            <template #title><i class="el-icon-menu"></i>Seguridad</template>
                            <el-menu-item-group>
                                <inertia-link :href="route('user.index')">
                                    <el-menu-item index="3-1">
                                        Usuarios
                                    </el-menu-item>
                                </inertia-link>
                            </el-menu-item-group>
                        </el-submenu>
                    </el-menu>
                </el-aside>
                <el-container>
                    <el-header class="shadow-md px-6">
                        <div class="grid grid-cols-12 h-full">
                            <div class="col-span-9 flex flex-wrap content-center">
                                <!-- Menu responsive -->
                                <el-menu mode="horizontal" class="sm:block md:hidden">
                                    <el-submenu index="4">
                                        <template #title>
                                            Menu
                                        </template>
                                        <el-submenu index="1" v-if="isAdmin">
                                            <template #title><i class="el-icon-user"></i> Delegados</template>
                                            <inertia-link :href="route('policia.index')">
                                                <el-menu-item index="1-1">
                                                    Gestionar delegados
                                                </el-menu-item>
                                            </inertia-link>
                                            <inertia-link :href="route('rango.index')">
                                                <el-menu-item index="1-3">
                                                    Gestionar grados
                                                </el-menu-item>
                                            </inertia-link>
                                        </el-submenu>
                                        <el-submenu index="5">
                                            <template #title><i class="el-icon-menu"></i>Evento</template>
                                            <el-menu-item-group>
                                                <inertia-link :href="route('cuadrante.index')" v-if="isAdmin">
                                                    <el-menu-item index="2-2">
                                                        Gestion de cuadrantes
                                                    </el-menu-item>
                                                </inertia-link>
                                                <inertia-link :href="route('invitacion.index')" v-if="isAdmin">
                                                    <el-menu-item index="2-1">
                                                        Invitaciones
                                                    </el-menu-item>
                                                </inertia-link>

                                                <inertia-link :href="route('invitacion.escanear')">
                                                    <el-menu-item index="2-1">
                                                        Escanear invitaciones
                                                    </el-menu-item>
                                                </inertia-link>

                                            </el-menu-item-group>
                                        </el-submenu>
                                        <el-submenu index="6" v-if="isAdmin">
                                            <template #title><i class="el-icon-menu"></i>Seguridad</template>
                                            <el-menu-item-group>
                                                <inertia-link :href="route('user.index')">
                                                    <el-menu-item index="3-1">
                                                        Usuarios
                                                    </el-menu-item>
                                                </inertia-link>
                                            </el-menu-item-group>
                                        </el-submenu>
                                    </el-submenu>
                                </el-menu>
                                <!-- En menu responsive -->

                                <!--                                    <el-breadcrumb-item :to="{ path: '/' }">Inicio</el-breadcrumb-item>-->
                                <!--                                </el-breadcrumb>-->
                            </div>
                            <div class="col-span-3 flex flex-wrap content-center justify-end">
                                <el-dropdown trigger="click">
                                    <div class="flex items-center">
                                        <el-avatar
                                            src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
                                            class="ml-1"
                                        >
                                        </el-avatar>
                                        <span class="font-semibold">
                                            {{ $page.props.user.name }}
                                        </span>

                                    </div>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item icon="el-icon-close" @click="logout">
                                                <span class="text-red-500"> Cerrar sesión</span>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </div>
                        </div>

                    </el-header>

                    <el-main class="bg-gray-100">
                        <slot></slot>
                    </el-main>
                    <!--                    <el-footer>Pie de página</el-footer>-->
                </el-container>
            </el-container>
        </el-container>
    </div>
</template>

<script>
export default {
    name: "AdminLayout",
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        }
    },
    data() {
        return {
            typeUser: ''
        }
    },
    created() {
        this.typeUser = this.$page.props.user.type;
    },
    computed: {
        isAdmin() {
            const USER_ADMIN = 'a';
            return this.typeUser == USER_ADMIN;
        }
    }
}
</script>

<style>

.el-main {
    /*background-color: #E9EEF3;*/
    color: #333;
}

body > .el-container {
    margin-bottom: 40px;
}

/*.el-header, .el-footer {*/
/*    background-color: #B3C0D1;*/
/*    color: #333;*/
/*    text-align: center;*/
/*    line-height: 60px;*/
/*}*/

/*************  CONFIGURACION DEL SIDEBAR *********/

.el-aside {
    background-color: #304156;
    color: #333;
}

.sidebar-container .el-menu {
    background-color: #304156;
    padding-left: 0px;
}

.el-menu.el-menu--inline .el-menu-item:hover {
    background-color: #001528 !important;
}

.el-menu.el-menu--inline .el-submenu__title:hover {
    background-color: #001528 !important;
}

.el-menu.el-menu--inline {
    background-color: #1f2d3d !important;
}

.el-submenu__title, .el-menu-item {
    color: rgb(191, 203, 217);
}

#aside-menu .el-submenu__title:hover, #aside-menu .el-menu-item:hover {
    background-color: #263445 !important;
}

#aside-menu .el-submenu__title:focus, #aside-menu .el-menu-item:focus {
    background-color: #263445 !important;
}

.el-aside .el-menu-item.is-active {
    background-color: #263445 !important;
    border-left: 3px solid green;
}

/******************************/


.el-container:nth-child(5) .el-aside,
.el-container:nth-child(6) .el-aside {
    line-height: 260px;
}

.el-container:nth-child(7) .el-aside {
    line-height: 320px;
}
</style>
