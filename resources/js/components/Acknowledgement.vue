<template>
    <div>
        <div v-html="page.content"></div>
        <!-- <br>
        <a class="btn btn-block btn-lg btn-primary" target="_blank" :href="url">{{buttonLabels[lang]}}</a> -->
    </div>
</template>

<script>
export default {
    props: ['url', 'lang'],
    data() {
        return {
            page: {},
            buttonLabels: {
                ar: 'الشروع في دفع',
                id: 'LAKUKAN PEMBAYARAN',
                en: 'PROCEED TO PAYMENT'
            },
        }
    },
    methods: {
        getPage() {
            axios.get(BASE_URL + '/acknowledgement').then(r => {
                this.page = r.data
            }).catch(e => console.log(e))
        }
    },
    mounted() {
        this.getPage()
    }
}
</script>

<style lang="scss" scoped>

</style>
