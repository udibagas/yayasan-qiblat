<template>
    <el-card>
        <h4>SETTING</h4>
        <hr>
        <el-form label-position="right" label-width="150px" style="width:700px;">
            <el-form-item v-for="s in settings" :key="s.id" :label="s.label">
                <el-input :type="s.type" rows="3" v-if="s.type === 'text' || s.type === 'textarea'" :placeholder="s.label" v-model="s.value"></el-input>
                <span class="text-muted">{{s.description}}</span>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="save"><i class="el-icon-check"></i> SIMPAN</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>

<script>
export default {
    data() {
        return {
            formModel: {},
            baseUrl: BASE_URL,
            settings: []
        }
    },
    methods: {
        save() {
            axios.post(BASE_URL + '/setting', { settings: this.settings })
                .then(r => {
                    this.$message({
                        message: 'Data BERHASIL disimpan.',
                        type: 'success'
                    });
                }).catch(e => {
                    this.$message({
                        message: 'Data GAGAL disimpan.',
                        type: 'error'
                    });
                })
        },
        getSettings() {
            axios.get(BASE_URL + '/setting')
                .then(r => this.settings = r.data)
                .catch(e => console.log(e))
        }
    },
    mounted() {
        this.getSettings()
    }
}
</script>

<style scoped>
</style>