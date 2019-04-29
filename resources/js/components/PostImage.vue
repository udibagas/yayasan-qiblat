<template>
    <div style="height:400px;overflow:auto;margin-top:15px">
        <el-upload
        ref="upload"
        :action="baseUrl + '/uploadImage'"
        list-type="picture-card"
        :show-file-list="true"
        :file-list="imageList"
        :on-remove="handleRemoveImage"
        :on-error="handleUploadImageError"
        :on-success="handleUploadImageSuccess">
        <i class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        <div class="error-feedback" v-if="error">{{error}}</div>
    </div>
</template>

<script>
export default {
    props: ['post'],
    watch: {
        post(v, o) {
            this.getImageList()
        }
    },
    data() {
        return {
            baseUrl: BASE_URL,
            error: '',
            imageList: []
        }
    },
    methods: {
        handleUploadImageSuccess(res, file, fileList) {
            let data = {
                path: res.path,
                post_id: this.post
            }
            axios.post(BASE_URL + '/postImage', data).then(r => {
                console.log(r)
            }).catch(e => console.log(e));
        },
        handleUploadImageError(err, file, fileList) {
            this.error = JSON.parse(err.message).message
            this.$forceUpdate();
            console.log(err);
        },
        handleRemoveImage(file, fileList) {
            let data = { path: file.url }
            axios.delete(BASE_URL + '/postImage', { data: data }).then(r => {
                let index = this.imageList.map(i => { return i.path }).indexOf(data.path)
                this.imageList.splice(index ,1)
            }).catch(e => console.log(e))
        },
        getImageList() {
            if (!!this.post) {
                let params = { post_id: this.post };
                axios.get(BASE_URL + '/postImage/', { params: params }).then(r => {
                    this.imageList = r.data.map(d => {
                        return {
                            name: d.description_id, 
                            url: d.path 
                        }
                    })
                }).catch(e => console.log(e))
            }
        },
        saveDescription() {

        }
    },
    mounted() {
        this.getImageList()
    }
    
}
</script>

<style lang="scss" scoped>

</style>