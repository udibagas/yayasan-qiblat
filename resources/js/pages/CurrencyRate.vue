<template>
    <transition name="el-fade-in-linear">
        <el-card>
            <h4>KELOLA MATA UANG</h4>
            <hr>
            <el-form :inline="true" style="text-align:right;">
                <el-form-item>
                    <el-button @click="addData" type="primary"><i class="el-icon-plus"></i> Tambah Mata Uang</el-button>
                </el-form-item>
            </el-form>

            <el-table :data="tableData" stripe v-loading="loading" style="border-top:1px solid #eee;">
                <el-table-column type="index" width="50"> </el-table-column>
                <el-table-column label="Flag">
                    <template slot-scope="scope">
                        <img v-if="scope.row.flag_image" class="thumbnail" :src="scope.row.flag_image" alt="">
                    </template>
                </el-table-column>
                <el-table-column prop="currency" label="Currency" sortable="custom"></el-table-column>
                <el-table-column prop="description" label="Description" sortable="custom"></el-table-column>
                <el-table-column prop="rate" label="Rate" sortable="custom"></el-table-column>

                <el-table-column prop="updated_at" label="Last Update" sortable="custom"></el-table-column>
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

            <el-dialog :visible.sync="showForm" :title="formTitle" width="600px" v-loading="loading" :close-on-click-modal="false">
                <el-alert type="error" title="ERROR"
                    :description="error.message + '\n' + error.file + ':' + error.line"
                    v-show="error.message"
                    style="margin-bottom:15px;">
                </el-alert>

                <el-form label-width="150px" label-position="right" :model="formModel">
                    <el-form-item label="Currency">
                        <el-input placeholder="Currency" v-model="formModel.currency"></el-input>
                        <div class="error-feedback" v-if="formErrors.currency">{{formErrors.currency[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Description">
                        <el-input placeholder="Description" v-model="formModel.description"></el-input>
                        <div class="error-feedback" v-if="formErrors.description">{{formErrors.description[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Rate">
                        <el-input type="number" step="any" placeholder="Rate" v-model="formModel.rate"></el-input>
                        <div class="error-feedback" v-if="formErrors.rate">{{formErrors.rate[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Flag">
                        <el-upload
                        :limit="1"
                        list-type="picture"
                        :file-list="!!formModel.flag_image ? [{name: '', url: formModel.flag_image}] : []"
                        :action="baseUrl + '/uploadImage'"
                        :on-remove="handleRemoveImage"
                        :on-error="handleUploadImageError"
                        :on-success="handleUploadImageSuccess">
                            <el-button type="primary">Click to upload</el-button>
                        </el-upload>
                        <div class="error-feedback" v-if="formErrors.flag_image">{{formErrors.flag_image[0]}}</div>
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
    data: function() {
        return {
            loading: false,
            showForm: false,
            formTitle: '',
            formErrors: {},
            error: {},
            formModel: {},
            tableData: [],
            baseUrl: BASE_URL
        }
    },
    methods: {
        handleUploadImageSuccess(res, file, fileList) {
            this.formModel.flag_image = res.path
            this.$forceUpdate();
        },
        handleUploadImageError(err, file, fileList) {
            this.formErrors.flag_image = [JSON.parse(err.message).message]
            this.$forceUpdate();
        },
        handleRemoveImage(file, fileList) {
            let data = { path: file.url }
            axios.delete(BASE_URL + '/currencyRate/deleteFlag', { data: data }).then(r => {
                this.formErrors.flag_image = ''
            }).catch(e => console.log(e))
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
            axios.post(BASE_URL + '/currencyRate', this.formModel).then(r => {
                this.loading = false;
                this.showForm = false;
                this.$message({
                    message: 'Data BERHASIL disimpan.',
                    type: 'success'
                });
                this.requestData();
            }).catch(e => {
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
            axios.put(BASE_URL + '/currencyRate/' + this.formModel.id, this.formModel).then(r => {
                this.loading = false;
                this.showForm = false
                this.$message({
                    message: 'Data BERHASIL disimpan.',
                    type: 'success'
                });
                this.requestData()
            }).catch(e => {
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
            this.formTitle = 'Tambah Currency'
            this.error = {}
            this.formErrors = {}
            this.formModel = {}
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Currency'
            data.status = !!(data.status);
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus data ini?', 'Warning').then(() => {
                axios.delete(BASE_URL + '/currencyRate/' + id).then(r => {
                    this.requestData();
                    this.$message({
                        message: 'User BERHASIL dihapus.',
                        type: 'success',
                        showClose: true
                    });
                }).catch(e => {
                    this.$message({
                        message: 'User GAGAL dihapus. ' + e.response.data.message,
                        type: 'error',
                        showClose: true
                    });
                })
            }).catch(e => console.log(e));
        },
        requestData: function() {
            this.loading = true;
            axios.get(BASE_URL + '/currencyRate').then(r => {
                this.loading = false;
                this.tableData = r.data
            }).catch(e => {
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

<style scoped>
img.thumbnail {
    height: 30px;
    width: 50px;
    border: 1px solid #ddd;
}
</style>
