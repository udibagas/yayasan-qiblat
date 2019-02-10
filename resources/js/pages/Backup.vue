<template>
    <el-card>
        <h4>BACKUP</h4>
        <hr>
        <el-form :inline="true">
            <el-form-item>
                <el-input v-model="fileName" placeholder="Nama file backup" style="width:300px;display:block;"></el-input>
                <span v-if="error" class="text-danger">{{error}}</span>
            </el-form-item>
            <el-form-item>
                <el-button :disabled="isGenerating || !fileName" @click="createBackup" type="primary">{{buttonLabel}}</el-button>
            </el-form-item>
        </el-form>
        <hr>
        <el-row :gutter="15">
            <el-col :span="12">
                <el-card>
                    <h3>Database</h3>
                    <hr>
                    <el-table :data="files">
                        <el-table-column prop="name" label="Name"> </el-table-column>
                        <el-table-column prop="size" label="Size"> </el-table-column>
                        <el-table-column prop="modified_at" label="Modified At"> </el-table-column>
                        <el-table-column fixed="right" width="40px">
                            <template slot-scope="scope">
                                <el-dropdown>
                                    <span class="el-dropdown-link">
                                        <i class="el-icon-more"></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item @click.native.prevent="downloadFile(scope.row)"><i class="el-icon-download"></i> Download</el-dropdown-item>
                                        <el-dropdown-item @click.native.prevent="deleteFile(scope.row)"><i class="el-icon-delete"></i> Hapus</el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
            </el-col>
            <el-col :span="12">
                <el-card>
                    <h3>Files</h3>
                    <hr>
                    <el-table :data="images">
                        <el-table-column prop="name" label="Name"> </el-table-column>
                        <el-table-column prop="size" label="Size"> </el-table-column>
                        <el-table-column prop="modified_at" label="Modified At"> </el-table-column>
                        <el-table-column fixed="right" width="40px">
                            <template slot-scope="scope">
                                <el-dropdown>
                                    <span class="el-dropdown-link">
                                        <i class="el-icon-more"></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item @click.native.prevent="downloadFile(scope.row)"><i class="el-icon-download"></i> Download</el-dropdown-item>
                                        <el-dropdown-item @click.native.prevent="deleteFile(scope.row)"><i class="el-icon-delete"></i> Hapus</el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
            </el-col>
        </el-row>
    </el-card>
</template>

<script>
import moment from 'moment'
export default {
    filters: {
        asDateTime(v) {
            return moment(v, 'X').format('DD/MMM/YYYY HH:mm:ss')
        }
    },
    data() {
        return {
            buttonLabel: 'Create Backup',
            isGenerating: false,
            fileName: '',
            error: '',
            files: [],
            images: [],
        }
    },
    methods: {
        requestData() {
            axios.get(BASE_URL + '/backup')
                .then(r => {
                    this.files = r.data.filter(f => f.name.includes('.sql')).sort((a,b) => { return b.modified_at - a.modified_at })
                    this.images = r.data.filter(f => f.name.includes('.zip')).sort((a,b) => { return b.modified_at - a.modified_at })
                })
                .catch(e => console.log(e));
        },
        createBackup() {
            if (!this.fileName) {
                this.error = 'Nama file harus diisi'
                return
            }
            this.error = ''
            this.buttonLabel = 'Generating backup file...'
            this.isGenerating = true
            axios.post(BASE_URL + '/backup', { fileName: this.fileName.replace(/ /g, '-') })
                .then(r => {
                    this.buttonLabel = 'Create Backup'
                    this.isGenerating = false
                    this.fileName = ''
                    this.requestData()
                })
                .catch(e => {
                    this.buttonLabel = 'Create Backup'
                    this.isGenerating = false
                    this.error = e.data.message
                });
        },
        downloadFile(file) {
            window.open(BASE_URL + '/backup?download=' + file.name);
        },
        deleteFile(file) {
            if (!confirm('Anda yakin?')) return;

            axios.delete(BASE_URL + '/backup?file=' + file.name)
                .then(r => this.requestData())
                .catch(e => console.log(e));
        }
    },
    mounted() {
        this.requestData()
    }
}
</script>

<style scoped>
.el-form-item {
    margin-bottom:0;
}
</style>