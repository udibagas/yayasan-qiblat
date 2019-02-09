<template>
    <el-row :gutter="20">
        <el-col :span="6">
            <img v-if="post.image" :src="post.image" alt="" class="thumbnail">
        </el-col>
        <el-col :span="18">
            <el-tabs tab-position="top" type="card">
                <el-tab-pane label="Indonesia">
                    <h3>{{post.title}}</h3>
                    <div v-html="post.content"></div>
                </el-tab-pane>
                <el-tab-pane label="English">
                    <h3>{{post.title_en}}</h3>
                    <div v-html="post.content_en"></div>
                </el-tab-pane>
                <el-tab-pane label="Arabic">
                    <h3>{{post.title_ar}}</h3>
                    <div v-html="post.content_ar"></div>
                </el-tab-pane>
            </el-tabs>
        </el-col>
    </el-row>
</template>

<script>
export default {
    props: ['post']
}
</script>

<style scoped>
img.thumbnail {
    border: 1px solid #ddd;
    padding: 4px;
    border-radius: 4px;
    width: 100%;
}
</style>