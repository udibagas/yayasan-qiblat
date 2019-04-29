import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        pagerOptions: [
            { value: 10, label: 10 },
            { value: 25, label: 25 },
            { value: 50, label: 50 },
            { value: 100, label: 100 },
        ],
        currencyList: [],
        postCategoryList: []
    },
    mutations: {
        getCurrencyList(state) {
            axios.get(BASE_URL + '/currencyRate/getList')
                .then(r => state.currencyList = r.data)
                .catch(e => console.log(e))
        },
        getPostCategoryList(state) {
            axios.get(BASE_URL + '/postCategory/getList')
                .then(r => state.postCategoryList = r.data)
                .catch(e => console.log(e))
        }
    }
})