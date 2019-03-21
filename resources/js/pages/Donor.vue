<template>
    <transition name="el-fade-in-linear">
        <el-card>
            <h4>KELOLA DONATUR</h4>
            <hr>
            <el-form :inline="true" style="text-align:right;">
                <el-form-item>
                    <el-select class="pager-options" v-model="pageSize" placeholder="Page Size">
                        <el-option v-for="item in $store.state.pagerOptions" :key="item.value" :label="item.label" :value="item.value"> </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item style="margin-right:0;">
                    <el-input placeholder="Search" prefix-icon="el-icon-search" v-model="keyword">
                        <el-button @click="refreshData" slot="append" icon="el-icon-refresh"></el-button>
                    </el-input>
                </el-form-item>
            </el-form>

            <el-table :data="paginatedData.data" stripe
            :default-sort = "{prop: 'name', order: 'ascending'}"
            v-loading="loading"
            style="border-top:1px solid #eee;"
            @filter-change="filterChange"
            @sort-change="sortChange">
                <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
                <el-table-column prop="name" label="Name" sortable="custom"></el-table-column>
                <el-table-column prop="email" label="Email" sortable="custom"></el-table-column>
                <el-table-column prop="phone" label="Phone" sortable="custom"></el-table-column>
                <el-table-column prop="address" label="Address" sortable="custom">
                    <template slot-scope="scope">
                        <span v-if="!!scope.row.address" v-html="scope.row.address.replace(/(?:\r\n|\r|\n)/g, '<br>')"></span>
                    </template>
                </el-table-column>
                <el-table-column prop="status" label="Status" sortable="custom" column-key="status"
                :filters="[{value: 0, text: 'Inactive'},{value: 1, text: 'Active'}]">
                    <template slot-scope="scope">
                        <span :class="scope.row.status ? 'text-success' : 'text-danger'">{{scope.row.status ? 'Active' : 'Inactive'}}</span>
                    </template>
                </el-table-column>

                <el-table-column prop="last_login" label="Last Login" sortable="custom"></el-table-column>
                <el-table-column prop="login" label="Login" sortable="custom"></el-table-column>

                <el-table-column fixed="right" width="40px">
                    <template slot-scope="scope">
                        <el-dropdown>
                            <span class="el-dropdown-link">
                                <i class="el-icon-more"></i>
                            </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item @click.native.prevent="editData(scope.row)"><i class="el-icon-edit-outline"></i> Edit</el-dropdown-item>
                                <el-dropdown-item @click.native.prevent="deleteData(scope.row.id)"><i class="el-icon-delete"></i> Hapus</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </template>
                </el-table-column>
            </el-table>

            <br>

            <el-row>
                <el-col :span="12">
                    <el-pagination @current-change="goToPage"
                        :page-size="pageSize"
                        background
                        layout="prev, pager, next"
                        :total="paginatedData.total">
                    </el-pagination>
                </el-col>
                <el-col :span="12" style="text-align:right">
                    {{ paginatedData.from }} - {{ paginatedData.to }} of {{ paginatedData.total }} items
                </el-col>
            </el-row>

            <el-dialog :visible.sync="showForm" :title="formTitle" width="600px" v-loading="loading" :close-on-click-modal="false">
                <el-alert type="error" title="ERROR"
                    :description="error.message + '\n' + error.file + ':' + error.line"
                    v-show="error.message"
                    style="margin-bottom:15px;">
                </el-alert>

                <el-form label-width="150px" label-position="right" :model="formModel">
                    <el-form-item label="Username">
                        <el-input placeholder="Username" v-model="formModel.name"></el-input>
                        <div class="error-feedback" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Email">
                        <el-input placeholder="Email" v-model="formModel.email"></el-input>
                        <div class="error-feedback" v-if="formErrors.email">{{formErrors.email[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Phone">
                        <el-input placeholder="Phone" v-model="formModel.phone"></el-input>
                        <div class="error-feedback" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Alamat">
                        <el-input type="textarea" rows="5" placeholder="Alamat" v-model="formModel.address"></el-input>
                        <div class="error-feedback" v-if="formErrors.address">{{formErrors.address[0]}}</div>
                    </el-form-item>

                    <!-- <el-form-item label="Password">
                        <el-input type="password" placeholder="Password" v-model="formModel.password"></el-input>
                        <div class="error-feedback" v-if="formErrors.password">{{formErrors.password[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Konfirmasi Password">
                        <el-input type="password" placeholder="Konfirmasi Password" v-model="formModel.password_confirmation"></el-input>
                        <div class="error-feedback" v-if="formErrors.password_confirmation">{{formErrors.password_confirmation[0]}}</div>
                    </el-form-item> -->

                    <el-form-item label="Status">
                        <el-switch v-model="formModel.status"></el-switch>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="save">Simpan</el-button>
                        <el-button @click="showForm = false">Batal</el-button>
                    </el-form-item>
                </el-form>
            </el-dialog>
        </el-card>
    </transition>
</template>

<script>
export default {
    watch: {
        keyword: function(v, o) {
            this.requestData()
        },
        pageSize: function(v, o) {
            this.requestData()
        }
    },
    data: function() {
        return {
            loading: false,
            showForm: false,
            formTitle: '',
            formErrors: {},
            error: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            sort: 'name',
            order: 'ascending',
            filters: {},
            paginatedData: {}
        }
    },
    methods: {
        sortChange: function(column) {
            if (this.sort !== column.prop || this.order !== column.order) {
                this.sort = column.prop;
                this.order = column.order;
                this.requestData();
            }
        },
        filterChange: function(f) {
            let column = Object.keys(f)[0];
            this.filters[column] = Object.values(f[column]);
            this.refreshData();
        },
        goToPage: function(p) {
            this.page = p;
            this.requestData();
        },
        save() {
            if (!!(this.formModel.id)) {
                this.update();
            } else {
                this.store();
            }
        },
        store: function() {
            this.loading = true;
            axios.post(BASE_URL + '/user', this.formModel)
                .then(r => {
                    this.loading = false;
                    this.showForm = false;
                    this.$message({
                        message: 'Data BERHASIL disimpan.',
                        type: 'success'
                    });
                    this.requestData();
                })
                .catch(e => {
                    this.loading = false;
                    if (e.response.status == 422) {
                        this.error = {}
                        this.formErrors = e.response.data.errors;
                    }

                    if (e.response.status == 500) {
                        this.formErrors = {}
                        this.error = e.response.data;
                    }
                })
        },
        update: function() {
            this.loading = true;
            axios.put(BASE_URL + '/user/' + this.formModel.id, this.formModel)
                .then(r => {
                    this.loading = false;
                    this.showForm = false
                    this.$message({
                        message: 'Data BERHASIL disimpan.',
                        type: 'success'
                    });
                    this.requestData()
                })
                .catch(e => {
                    this.loading = false;
                    if (e.response.status == 422) {
                        this.error = {}
                        this.formErrors = e.response.data.errors;
                    }

                    if (e.response.status == 500) {
                        this.formErrors = {}
                        this.error = e.response.data;
                    }
                })
        },
        addData: function() {
            this.formTitle = 'Tambah User'
            this.error = {}
            this.formErrors = {}
            this.formModel = {}
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit User'
            data.status = !!(data.status);
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus user ini?')
                .then(() => {
                    axios.delete(BASE_URL + '/user/' + id)
                        .then(r => {
                            this.requestData();
                            this.$message({
                                message: 'User BERHASIL dihapus.',
                                type: 'success'
                            });
                        })
                        .catch(e => {
                            this.$message({
                                message: 'User GAGAL dihapus. ' + e.response.data.message,
                                type: 'error'
                            });
                        })
                })
                .catch(() => {

                });
        },
        refreshData: function() {
            this.keyword = '';
            this.page = 1;
            this.requestData();
        },
        requestData: function() {
            let params = {
                page: this.page,
                keyword: this.keyword,
                pageSize: this.pageSize,
                sort: this.sort,
                order: this.order,
                role: [0]
            }
            this.loading = true;

            axios.get(BASE_URL + '/user', {params: Object.assign(params, this.filters)})
                .then(r => {
                    this.loading = false;
                    this.paginatedData = r.data
                })
                .catch(e => {
                    this.loading = false;
                    this.$message({
                        message: e.response.data.message || e.response.message,
                        type: 'error'
                    });
                })
        }
    },
    created: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
</style>
