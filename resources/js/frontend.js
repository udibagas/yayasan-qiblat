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
    // return v;
    try {
        v += '';
        var x = v.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';

        if (parseInt(x[1]) == 0) {
            x2 = ''
        }

        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
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
