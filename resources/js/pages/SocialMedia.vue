<template>
    <transition name="el-fade-in-linear">
        <el-card>
            <h4>KELOLA MEDIA SOSIAL</h4>
            <hr>
            <el-form :inline="true" style="text-align:right;">
                <el-form-item>
                    <el-button @click="addData" type="primary"><i class="el-icon-plus"></i> Tambah Media Sosial</el-button>
                </el-form-item>
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
            :default-sort = "{prop: 'provider', order: 'ascending'}"
            v-loading="loading"
            style="border-top:1px solid #eee;"
            @filter-change="filterChange"
            @sort-change="sortChange">
                <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
                <el-table-column prop="icon" label="Icon" width="150px">
                    <!-- <template slot-scope="scope">
                        <i :class="scope.row.icon"></i>
                    </template> -->
                </el-table-column>
                <el-table-column prop="provider" label="Provider" sortable="custom"></el-table-column>
                <el-table-column prop="account" label="Akun" sortable="custom"></el-table-column>
                <el-table-column prop="url" label="URL" sortable="custom"></el-table-column>

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
                    <el-form-item label="Provider">
                        <el-input placeholder="Provider" v-model="formModel.provider"></el-input>
                        <div class="error-feedback" v-if="formErrors.provider">{{formErrors.provider[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Akun">
                        <el-input placeholder="Akun" v-model="formModel.account"></el-input>
                        <div class="error-feedback" v-if="formErrors.account">{{formErrors.account[0]}}</div>
                    </el-form-item>

                    <el-form-item label="URL">
                        <el-input placeholder="URL" v-model="formModel.url"></el-input>
                        <div class="error-feedback" v-if="formErrors.url">{{formErrors.url[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Icon">
                        <el-input placeholder="Icon" v-model="formModel.icon"></el-input>
                        <div class="error-feedback" v-if="formErrors.icon">{{formErrors.icon[0]}}</div>
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
            sort: 'provider',
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
            axios.post(BASE_URL + '/socialMedia', this.formModel)
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
            axios.put(BASE_URL + '/socialMedia/' + this.formModel.id, this.formModel)
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
            this.formTitle = 'Tambah Media Sosial'
            this.error = {}
            this.formErrors = {}
            this.formModel = {}
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Media Sosial'
            data.status = !!(data.status);
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus user ini?')
                .then(() => {
                    axios.delete(BASE_URL + '/socialMedia/' + id)
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
            }
            this.loading = true;

            axios.get(BASE_URL + '/socialMedia', {params: Object.assign(params, this.filters)})
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
