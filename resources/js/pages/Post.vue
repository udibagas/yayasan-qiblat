<template>
    <el-card>
        <h4>KELOLA POST</h4>
        <hr>

        <el-form :inline="true" style="text-align:right;">
            <el-form-item>
                <el-button @click="addData" type="primary"><i class="el-icon-plus"></i> Tambah Post</el-button>
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
        :default-sort = "{prop: 'updated_at', order: 'descending'}"
        v-loading="loading"
        style="border-top:1px solid #eee;"
        @filter-change="filterChange"
        @sort-change="sortChange">
            <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <PostPreview :post="scope.row" />
                </template>
            </el-table-column>
            <el-table-column label="Image">
                <template slot-scope="scope">
                    <img v-if="scope.row.image" class="thumbnail" :src="scope.row.image" alt="">
                </template>
            </el-table-column>
            <el-table-column prop="title_id" label="Judul" sortable="custom"></el-table-column>
            <el-table-column prop="type" label="Jenis" sortable="custom"></el-table-column>
            <el-table-column prop="category.name_id" label="Kategori"></el-table-column>
            <el-table-column prop="status" label="Status" sortable="custom" column-key="status"
            :filters="[{value: 0, text: 'Inactive'},{value: 1, text: 'Active'}]">
                <template slot-scope="scope">
                    <span :class="scope.row.status ? 'text-success' : 'text-danger'">{{scope.row.status ? 'Active' : 'Inactive'}}</span>
                </template>
            </el-table-column>
            <el-table-column prop="updated_at" label="Terakhir Diupdate" sortable="custom" width="150px"></el-table-column>

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

        <el-dialog :visible.sync="showForm" :title="formTitle" width="90%" v-loading="loading" :close-on-click-modal="false" @close="closeForm">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-row :gutter="20">
                <el-col :span="16">
                    <el-form :model="formModel">
                        <el-tabs tab-position="top" type="card">
                            <el-tab-pane label="Indonesia">
                                <br>
                                <el-form-item label="">
                                    <el-input placeholder="Judul" v-model="formModel.title_id"></el-input>
                                    <div class="error-feedback" v-if="formErrors.title_id">{{formErrors.title_id[0]}}</div>
                                </el-form-item>

                                <el-form-item label="">
                                    <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.content_id"></vue-editor>
                                    <div class="error-feedback" v-if="formErrors.content_id">{{formErrors.content[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="English">
                                <br>
                                <el-form-item label="">
                                    <el-input placeholder="Title" v-model="formModel.title_en"></el-input>
                                    <div class="error-feedback" v-if="formErrors.title_en">{{formErrors.title_en[0]}}</div>
                                </el-form-item>

                                <el-form-item label="">
                                    <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.content_en"></vue-editor>
                                    <div class="error-feedback" v-if="formErrors.content_en">{{formErrors.content_en[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="Arabic">
                                <br>
                                <el-form-item label="">
                                    <el-input placeholder="Judul" v-model="formModel.title_ar"></el-input>
                                    <div class="error-feedback" v-if="formErrors.title_ar">{{formErrors.title_ar[0]}}</div>
                                </el-form-item>

                                <el-form-item label="">
                                    <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="formModel.content_ar"></vue-editor>
                                    <div class="error-feedback" v-if="formErrors.content_ar">{{formErrors.content_ar[0]}}</div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane label="Galeri" v-if="formModel.id">
                                <PostImage :post="formModel.id" />
                            </el-tab-pane>
                        </el-tabs>
                    </el-form>
                </el-col>

                <el-col :span="8">
                    <el-upload
                    ref="upload"
                    class="avatar-uploader"
                    :action="baseUrl + '/uploadImage'"
                    :show-file-list="false"
                    :on-error="handleUploadImageError"
                    :on-success="handleUploadImageSuccess">
                        <img v-if="imageUrl" :src="imageUrl" class="avatar">
                        <i v-else class="el-icon-picture avatar-uploader-icon"></i>
                    </el-upload>
                    <div class="error-feedback" v-if="formErrors.file">{{formErrors.file[0]}}</div>

                    <br>
                    <br>
                    <el-form label-width="100px" label-position="left">
                        <el-form-item label="Jenis">
                            <el-select placeholder="Jenis" v-model="formModel.type" style="width:100%;">
                                <el-option value="post" label="Post"></el-option>
                                <el-option value="page" label="Page"></el-option>
                            </el-select>
                            <div class="error-feedback" v-if="formErrors.type">{{formErrors.type[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Kategori" v-show="formModel.type == 'post'">
                            <treeselect v-model="formModel.post_category_id" :multiple="false" :options="categories" />
                            <div class="error-feedback" v-if="formErrors.post_category_id">{{formErrors.post_category_id[0]}}</div>
                        </el-form-item>

                        <el-form-item label="Status">
                            <el-switch v-model="formModel.status"></el-switch>
                        </el-form-item>
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
import { VueEditor, Quill } from 'vue2-editor'
import PostPreview from '../components/PostPreview'
import PostImage from '../components/PostImage'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

// import { ImageDrop } from 'quill-image-drop-module'
// import ImageResize from 'quill-image-resize-module'

// Quill.register('modules/imageDrop', ImageDrop)
// Quill.register('modules/imageResize', ImageResize)

export default {
    components: { VueEditor, PostPreview, Treeselect, PostImage },
    watch: {
        keyword: function(v, o) {
            this.requestData()
        },
        pageSize: function(v, o) {
            this.requestData()
        },
        'formModel.title_id': function(v, o) {
            if (v) {
                this.formModel.slug_id = v.split(' ').join('-');
            }
        },
        'formModel.title_en': function(v, o) {
            if (v) {
                this.formModel.slug_en = v.split(' ').join('-');
            }
        },
        'formModel.title_ar': function(v, o) {
            if (v) {
                this.formModel.slug_ar = v.split(' ').join('-');
            }
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
            sort: 'updated_at',
            order: 'descending',
            filters: {},
            paginatedData: {},
            imageUrl: '',
            categories: [],
            editorOptions: {
                modules: {
                    imageDrop: true,
                    imageResize: {}
                }
            }
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
            axios.post(BASE_URL + '/post', this.formModel)
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
            axios.put(BASE_URL + '/post/' + this.formModel.id, this.formModel)
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
            this.formTitle = 'Tambah Post'
            this.error = {}
            this.formErrors = {}
            this.formModel = {}
            this.showForm = true
        },
        editData: function(data) {
            this.formTitle = 'Edit Post'
            this.formModel = JSON.parse(JSON.stringify(data));
            this.error = {}
            this.formErrors = {}
            this.imageUrl = data.image
            this.showForm = true
        },
        deleteData: function(id) {
            this.$confirm('Anda yakin akan menghapus data ini?')
                .then(() => {
                    axios.delete(BASE_URL + '/post/' + id)
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

            axios.get(BASE_URL + '/post', {params: Object.assign(params, this.filters)})
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
        },
        getCategoy() {
            axios.get(BASE_URL + '/postCategory').then(r => {
                this.categories = r.data
            }).catch(e => console.log(e));
        }
    },
    created: function() {
        this.requestData();
        this.getCategoy()
    }
}
</script>

<style lang="css" scoped>
.avatar-uploader {
    border: 1px dashed #d9d9d9;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 200px;
}

.avatar-uploader:hover {
    border-color: #409EFF;
}

.avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 200px;
    height: 200px;
    line-height: 200px;
    text-align: center;
}

.avatar {
    width: 100%;
    /* height: 200px; */
    display: block;
}

img.thumbnail {
    height: 50px;
    border: 1px solid #ddd;
}
</style>
