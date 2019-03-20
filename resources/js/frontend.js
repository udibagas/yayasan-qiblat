require('./bootstrap');


import Vue from 'vue'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import store from './store'
import moment from 'moment'
import DonateForm from './components/DonateForm'
import MessageForm from './components/MessageForm'

Vue.filter('readableDate', function(v) {
    return v ? moment(v).format("DD/MMM/YYYY") : "";
});

Vue.filter('readableDateTime', function(v) {
    return v ? moment(v).format("DD/MMM/YYYY HH:mm") : '';
});

Vue.filter('formatNumber', function (v) {
    try {
        return parseFloat(v)
            .toFixed(0)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    } catch (error) {
        return 0
    }
    
});

Vue.use(ElementUI, { locale });

const app = new Vue({
    el: '#app',
    store,
    components: { DonateForm, MessageForm }
});