<template>
    <el-card>
        <h4>KELOLA PAKET PROGRAM</h4>
        <hr>

        <el-form :inline="true" style="text-align:right;">
            <el-form-item>
                <el-button @click="addData" type="primary"><i class="el-icon-plus"></i> Tambah Paket Program</el-button>
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
        :default-sort = "{prop: 'name_id', order: 'ascending'}"
        v-loading="loading"
        style="border-top:1px solid #eee;"
        @filter-change="filterChange"
        @sort-change="sortChange">
            <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
            <el-table-column min-width="200" prop="program.name_id" label="Program" sortable="custom"></el-table-column>
            <el-table-column min-width="100" prop="name_id" label="Paket" sortable="custom"></el-table-column>

            <el-table-column width="100" v-for="c in currencies" :key="c.id" :label="c.currency" align="center" header-align="center">
                <template slot-scope="scope">
                    {{ getPrice(c.id, scope.row.prices) | formatNumber }}
                </template>
            </el-table-column>

            <el-table-column width="150" prop="flexible_amount" label="Jumlah Flexible" sortable="custom" column-key="flexible_amount"
            :filters="[{value: 0, text: 'No'},{value: 1, text: 'Yes'}]">
                <template slot-scope="scope">
                    <span :class="scope.row.flexible_amount ? 'text-success' : 'text-danger'">{{scope.row.flexible_amount ? 'Yes' : 'No'}}</span>
                </template>
            </el-table-column>

            <el-table-column width="100" prop="minimum_qty" label="Min. Qty" sortable="custom"></el-table-column>

            <el-table-column width="170" prop="allow_multiple" label="Berlaku Kelipatan" sortable="custom" column-key="allow_multiple"
            :filters="[{value: 0, text: 'No'},{value: 1, text: 'Yes'}]">
                <template slot-scope="scope">
                    <span :class="scope.row.allow_multiple ? 'text-success' : 'text-danger'">{{scope.row.allow_multiple ? 'Yes' : 'No'}}</span>
                </template>
            </el-table-column>

            <el-table-column width="100" prop="multiple_step" label="Kelipatan" sortable="custom"></el-table-column>

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

        <el-dialog :visible.sync="showForm" :title="formTitle" width="800px" v-loading="loading" :close-on-click-modal="false" @close="closeForm">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-row :gutter="15">
                <el-col :span="6">
                    <el-upload
                    ref="upload"
                    class="avatar-uploader"
                    :action="baseUrl + '/uploadImage'"
                    :show-file-list="false"
                    :on-error="handleUploadImageError"
                    :on-success="handleUploadImageSuccess">
                        <img v-if="imageUrl" :src="imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                    <div class="error-feedback" v-if="formErrors.file">{{formErrors.file[0]}}</div>
                </el-col>
                <el-col :span="18">
                    <el-form label-width="150px" label-position="right" :model="formModel">
                        <el-tabs tab-position="top" type="card">
                            <el-tab-pane label="Indonesia">
                                <br>
                                <el-form-item label="Nama Paket">
                                    <el-input placeholder="Nama Paket Program" v-model="formModel.name_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_id">{{formErrors.name_id[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Keterangan">
                                    <!-- <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.description"></vue-editor> -->
                                    <el-input type="textarea" rows="8" placeholder="Keterangan" v-model="formModel.description_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_id">{{formErrors.description_id[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="English">
                                <br>
                                <el-form-item label="Package Name">
                                    <el-input placeholder="Package Name" v-model="formModel.name_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_en">{{formErrors.name_en[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Description">
                                    <!-- <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.description_en"></vue-editor> -->
                                    <el-input type="textarea" rows="8" placeholder="Description" v-model="formModel.description_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_en">{{formErrors.description_en[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="Arabic">
                                <br>
                                <el-form-item label="Package Name">
                                    <el-input placeholder="Package Name" v-model="formModel.name_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_ar">{{formErrors.name_ar[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Description">
                                    <!-- <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.description_ar"></vue-editor> -->
                                    <el-input type="textarea" rows="8" placeholder="Description" v-model="formModel.description_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_ar">{{formErrors.description_ar[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                        </el-tabs>

                        <el-form-item label="Program">
                            <el-select placeholder="Program" v-model="formModel.program_id" style="width:100%;">
                            <el-option v-for="p in programs" :value="p.id" :label="p.name_id" :key="p.id"></el-option>
                            </el-select>
                            <div class="error-feedback" v-if="formErrors.program_id">{{formErrors.program_id[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Harga Flexibel">
                            <el-switch v-model="formModel.flexible_amount"></el-switch>
                        </el-form-item>

                        <el-form-item label="Minimum Qty">
                            <el-input v-model="formModel.minimum_qty" type="number" placeholder="Minimum Qty"></el-input>
                        </el-form-item>

                        <el-form-item label="Berlaku Kelipatan">
                            <el-switch v-model="formModel.allow_multiple"></el-switch>
                        </el-form-item>

                        <el-form-item label="Kelipatan" v-show="!!formModel.allow_multiple">
                            <el-input v-model="formModel.multiple_step" type="number" placeholder="Kelipatan"></el-input>
                        </el-form-item>
                    </el-form>
                </el-col>
            </el-row>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr> <th class="text-center" v-for="c in currencies" :key="c.id">{{c.currency}}</th> </tr>
                </thead>
                <tbody>
                    <tr>
                        <td v-for="c in currencies" :key="c.id">
                            <input v-model="formModel.prices[c.id]" type="number" class="my-input">
                        </td>
                    </tr>
                </tbody>
            </table>

            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="save">Simpan</el-button>
                <el-button @click="showForm = false">Batal</el-button>
            </span>
        </el-dialog>
    </el-card>
</template>

<script>
import { VueEditor } from 'vue2-editor'

export default {
    components: { VueEditor },
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
            formModel: { prices: [] },
            keyword: '',
            page: 1,
            pageSize: 10,
            sort: 'name_id',
            order: 'ascending',
            filters: {},
            paginatedData: {},
            programs: [],
            currencies: [],
            imageUrl: ''
        }
    },
    methods: {
        getPrice(currency, prices) {
            let price = prices.find(p => p.currency_rate_id == currency)
            return price ? price.price : 0;
        },
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append('file', file)

            axios({
                url: BASE_URL + '/uploadImage',
                method: 'POST',
                data: formData
            }).then((result) => {
                let url = result.data.path // Get url from response
                Editor.insertEmbed(cursorLocation, 'image', url);
                resetUploader();
            }).catch((err) => {
                console.log(err);
            })
        },
        handleUploadImageSuccess(res, file, fileList) {
            this.imageUrl = URL.createObjectURL(file.raw);
            this.formModel.image = res.path
            this.$forceUpdate();
        },
        handleUploadImageError(err, file, fileList) {
            this.formErrors.file = [JSON.parse(err.message).message]
            this.$forceUpdate();
            console.log(err);
        },
        closeForm: function() {
            this.error = {};
            this.formErrors = {};
            if (this.$refs.upload) {
                this.$refs.upload.clearFiles();
            }
            this.imageUrl = ''
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
            axios.post(BASE_URL + '/programPackage', this.formModel)
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
            axios.put(BASE_URL + '/programPackage/' + this.formModel.id, this.formModel)
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
            this.formTitle = 'Tambah Paket Program'
            this.error = {}
            this.formErrors = {}
            this.formModel = { prices: [] }
            this.currencies.forEach(c => {
                this.formModel.prices[c.id] = 0
            });
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Paket Program'
            data.flexible_amount = !!(data.flexible_amount);
            this.formModel = JSON.parse(JSON.stringify(data));
            
            if (data.prices.length == 0) {
                this.currencies.forEach(c => {
                    this.formModel.prices[c.id] = 0
                });
            } else {
                data.prices.forEach(p => {
                    this.formModel.prices[p.currency_rate_id] = p.price
                });
            }

            this.imageUrl = data.image
            this.error = {}
            this.formErrors = {}
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus data ini?').then(() => {
                axios.delete(BASE_URL + '/programPackage/' + id).then(r => {
                    this.requestData();
                    this.$message({
                        message: 'Data BERHASIL dihapus.',
                        type: 'success'
                    });
                }).catch(e => {
                    this.$message({
                        message: 'Data GAGAL dihapus.',
                        type: 'error'
                    });
                })
            }).catch(() => { });
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

            axios.get(BASE_URL + '/programPackage', {params: Object.assign(params, this.filters)}).then(r => {
                this.loading = false;
                this.paginatedData = r.data
            }).catch(e => {
                this.loading = false;
                this.$message({
                    message: e.response.data.message || e.response.message,
                    type: 'error'
                });
            })
        },
        getProgram() {
            axios.get(BASE_URL + '/program/getList')
                .then(r => this.programs = r.data)
                .catch(e => {
                    console.log(e)
                })
        }
    },
    created: function() {
        axios.get(BASE_URL + '/currencyRate').then(r => {
            this.currencies = r.data
        }).catch(e => console.log(e))

        this.getProgram()
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

.my-input {
    width: 100px;
    border: 1px solid #ddd;
    padding-left: 5px;
    padding-right: 5px;
}
</style>
