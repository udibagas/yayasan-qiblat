<template>
    <el-card>
        <h4>KELOLA KATEGORI POST</h4>
        <hr>

        <el-form :inline="true" style="text-align:right;">
            <el-form-item>
                <el-button @click="addData(0)" type="primary"><i class="el-icon-plus"></i> Tambah Kategori Post</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input placeholder="Search" prefix-icon="el-icon-search" v-model="keyword">
                    <el-button @click="refreshData" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>
        
        <el-card>
            <el-tree :data="treeData" default-expand-all :expand-on-click-node="false">
                <span class="custom-tree-node" slot-scope="{ node, data }">
                    <span><i class="el-icon-document"></i>  {{ data.name_id }} / {{ data.name_en }} / {{ data.name_ar }}</span>
                    <span>
                    <el-button
                        type="text"
                        size="mini"
                        icon="el-icon-edit"
                        @click="() => editData(data)">
                    </el-button>
                    <el-button
                        type="text"
                        size="mini"
                        icon="el-icon-plus"
                        @click="() => addData(data.id)">
                    </el-button>
                    <el-button
                        type="text"
                        size="mini"
                        icon="el-icon-minus"
                        @click="() => deleteData(data.id)">
                    </el-button>
                    </span>
                </span>
            </el-tree>
        </el-card>

        <el-dialog :visible.sync="showForm" :title="formTitle" width="700px" v-loading="loading" :close-on-click-modal="false" @close="closeForm">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-row :gutter="15">
                <el-col :span="6" style="justify-content:center">
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
                    <el-form label-width="120px" label-position="right" :model="formModel">
                        <el-tabs tab-position="top" type="card">
                            <el-tab-pane label="Indonesia">
                                <br>
                                <el-form-item label="Parent">
                                    <treeselect v-model="formModel.parent_id" :multiple="false" :options="treeData" />
                                </el-form-item>

                                <el-form-item label="Nama Kategori">
                                    <el-input placeholder="Nama Kategori" v-model="formModel.name_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_id">{{formErrors.name_id[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Keterangan">
                                    <el-input type="textarea" rows="3" placeholder="Keterangan" v-model="formModel.description_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_id">{{formErrors.description_id[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Slug">
                                    <el-input placeholder="Slug" v-model="formModel.slug_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.slug_id">{{formErrors.slug_id[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="English">
                                <br>
                                <el-form-item label="Parent">
                                    <treeselect v-model="formModel.parent_id" :multiple="false" :options="treeData" />
                                </el-form-item>

                                <el-form-item label="Category Name">
                                    <el-input placeholder="Category Name" v-model="formModel.name_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_en">{{formErrors.name_en[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Description">
                                    <el-input type="textarea" rows="3" placeholder="Description" v-model="formModel.description_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_en">{{formErrors.description_en[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Slug">
                                    <el-input placeholder="Slug" v-model="formModel.slug_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.slug_en">{{formErrors.slug_en[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="Arabic">
                                <br>
                                <el-form-item label="Parent">
                                    <treeselect v-model="formModel.parent_id" :multiple="false" :options="treeData" />
                                </el-form-item>

                                <el-form-item label="Category Name">
                                    <el-input placeholder="Category Name" v-model="formModel.name_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.name_ar">{{formErrors.name_ar[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Description">
                                    <el-input type="textarea" rows="3" placeholder="Description" v-model="formModel.description_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.description_ar">{{formErrors.description_ar[0]}}</div>
                                </el-form-item>

                                <el-form-item label="Slug">
                                    <el-input placeholder="Slug" v-model="formModel.slug_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.slug_ar">{{formErrors.slug_ar[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                        </el-tabs>

                    </el-form>
                </el-col>
            </el-row>

            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="save">Simpan</el-button>
                <el-button @click="showForm = false">Batal</el-button>
            </span>

        </el-dialog>
    </el-card>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
    components: { Treeselect },
    computed: {
        categories() { return this.$store.state.postCategoryList }
    },
    watch: {
        keyword: function(v, o) {
            this.requestData()
        },
        'formModel.name_id': function(v, o) {
            if (v) {
                this.formModel.slug_id = v.split(' ').join('-');
            }
        },
        'formModel.name_en': function(v, o) {
            if (v) {
                this.formModel.slug_en = v.split(' ').join('-');
            }
        },
        'formModel.name_ar': function(v, o) {
            if (v) {
                this.formModel.slug_ar = v.split(' ').join('-');
            }
        },
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
            treeData: [],
            imageUrl: '',
        }
    },
    methods: {
        closeForm: function() {
            this.error = {};
            this.formErrors = {};
            if (this.$refs.upload) {
                this.$refs.upload.clearFiles();
            }
            this.imageUrl = ''
            this.showForm = false
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
        save() {
            if (!!(this.formModel.id)) {
                this.update();
            } else {
                this.store();
            }
        },
        store: function() {
            this.loading = true;
            axios.post(BASE_URL + '/postCategory', this.formModel)
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
            axios.put(BASE_URL + '/postCategory/' + this.formModel.id, this.formModel)
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
        addData: function(parent_id) {
            this.formTitle = 'Tambah Kategori Post'
            this.error = {}
            this.formErrors = {}
            this.formModel = { }
            
            if (!!parent_id) {
                this.formModel.parent_id = parent_id
            }

            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Kategori Post'
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.imageUrl = data.image
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus data ini?')
                .then(() => {
                    axios.delete(BASE_URL + '/postCategory/' + id)
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
            this.requestData();
        },
        requestData: function() {
            let params = { keyword: this.keyword }
            this.loading = true;

            axios.get(BASE_URL + '/postCategory', {params: params})
                .then(r => {
                    this.loading = false;
                    this.treeData = r.data
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
        this.$store.commit('getPostCategoryList')
    }
}
</script>

<style lang="css" scoped>
.custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
}

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
