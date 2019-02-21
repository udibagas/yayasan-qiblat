<template>
    <el-card>
        <h4>KELOLA PROGRAM</h4>
        <hr>

        <el-form :inline="true" style="text-align:right;">
            <el-form-item>
                <el-button @click="addData" type="primary"><i class="el-icon-plus"></i> Tambah Program</el-button>
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
        :default-sort = "{prop: 'name', order: 'ascending'}"
        v-loading="loading"
        style="border-top:1px solid #eee;"
        @filter-change="filterChange"
        @sort-change="sortChange">
            <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
            <el-table-column prop="name" label="Nama Program" sortable="custom"></el-table-column>
            <el-table-column prop="description" label="Description" sortable="custom"></el-table-column>

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

        <el-dialog :visible.sync="showForm" :title="formTitle" width="700px" v-loading="loading" :close-on-click-modal="false" @close="closeForm">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-form label-width="120px" label-position="right" :model="formModel">
                <el-tabs tab-position="top" type="card">
                    <el-tab-pane label="Indonesia">
                        <br>
                        <el-form-item label="Nama Program">
                            <el-input placeholder="Nama Program" v-model="formModel.name"></el-input>
                            <div class="error-feedback" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Keterangan">
                            <el-input type="textarea" rows="3" placeholder="Keterangan" v-model="formModel.description"></el-input>
                            <div class="error-feedback" v-if="formErrors.description">{{formErrors.description[0]}}</div>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="English">
                        <br>
                        <el-form-item label="Program Name">
                            <el-input placeholder="Program Name" v-model="formModel.name_en"></el-input>
                            <div class="error-feedback" v-if="formErrors.name_en">{{formErrors.name_en[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Description">
                            <el-input type="textarea" rows="3" placeholder="Description" v-model="formModel.description_en"></el-input>
                            <div class="error-feedback" v-if="formErrors.description_en">{{formErrors.description_en[0]}}</div>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="Arabic">
                        <br>
                        <el-form-item label="Program Name">
                            <el-input placeholder="Program Name" v-model="formModel.name_ar"></el-input>
                            <div class="error-feedback" v-if="formErrors.name_ar">{{formErrors.name_ar[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Description">
                            <el-input type="textarea" rows="3" placeholder="Description" v-model="formModel.description_ar"></el-input>
                            <div class="error-feedback" v-if="formErrors.description_ar">{{formErrors.description_ar[0]}}</div>
                        </el-form-item>
                    </el-tab-pane>
                </el-tabs>

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
            baseUrl: BASE_URL,
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
            paginatedData: {},
        }
    },
    methods: {
        closeForm: function() {
            this.error = {};
            this.formErrors = {};
            this.showForm = false
        },
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
            axios.post(BASE_URL + '/program', this.formModel)
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
            axios.put(BASE_URL + '/program/' + this.formModel.id, this.formModel)
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
            this.formTitle = 'Tambah Program'
            this.error = {}
            this.formErrors = {}
            this.formModel = {}
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Program'
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus data ini?')
                .then(() => {
                    axios.delete(BASE_URL + '/program/' + id)
                        .then(r => {
                            this.requestData();
                            this.$message({
                                message: 'Data BERHASIL dihapus.',
                                type: 'success'
                            });
                        })
                        .catch(e => {
                            this.$message({
                                message: 'Data GAGAL dihapus.',
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
                order: this.order
            }
            this.loading = true;

            axios.get(BASE_URL + '/program', {params: Object.assign(params, this.filters)})
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
.avatar-uploader {
    border: 1px dashed #d9d9d9;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 150px;
    height: 150px;
}

.avatar-uploader:hover {
    border-color: #409EFF;
}

.avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
}

.avatar {
    width: 150px;
    height: 150px;
    display: block;
}

img.thumbnail {
    height: 50px;
    border: 1px solid #ddd;
}
</style>
