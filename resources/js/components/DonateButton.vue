<template>
    <div>
        <hr>
        <div v-if="xenditResponse">
            <h1>Terimakasih!</h1>
            <p>
                Terimakasih atas donasi Anda. Silakan transfer ke bank berikut sejumlah 
                <span class="amount">Rp {{xenditResponse.amount | formatNumber}}</span> 
                sebelum <span class="time">{{ xenditResponse.expiry_date | readableDateTime }}</span>  :
            </p>
            
            <ul>
                <li v-for="b in xenditResponse.available_banks" :key="b.bank_code">
                    <h5 class="bank-code"> {{b.bank_code}} </h5>
                    Nomor Virtual Account <span class="account-number">{{b.bank_account_number}}</span> <br>
                    A.n <span class="account-name">{{b.account_holder_name}}</span>
                    <hr>
                </li>

            </ul>
        </div>
        <p v-if="flexible"><i>Masukkan jumlah yang akan Anda donasikan:</i></p>
        <input type="number" v-model="amountFinal" class="form-control input-lg" :disabled="!flexible"><br>
        <button v-show="!xenditResponse" :disabled="disabled" class="btn btn-block btn-primary btn-lg" @click="donate">{{buttonLabel}}</button>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    props: ['program', 'package', 'amount', 'remark', 'label', 'flexible'],
    filters: {
        readableDateTime(v) {
            return moment(v).format('DD MMM YYYY HH:mm')
        }
    },
    data() {
        return {
            disabled: false,
            buttonLabel: '',
            xenditResponse: null,
            amountFinal: 0
            // xenditResponse: {"id":"5c6d064d0718f34ae954be31","external_id":"donasi_qiblat_4","user_id":"57fdbb445eec38910d3a4c47","status":"PENDING","merchant_name":"Your Company","merchant_profile_picture_url":"https:\/\/xnd-companies.s3.amazonaws.com\/prod\/1476344224287_930.png","amount":3000000,"payer_email":"udibagas@gmail.com","description":"Percetakan Mushaf - Paket C","expiry_date":"2019-02-21T07:48:29.415Z","invoice_url":"https:\/\/invoice-staging.xendit.co\/web\/invoices\/5c6d064d0718f34ae954be31","available_banks":[{"bank_code":"MANDIRI","collection_type":"POOL","bank_account_number":"8860838041787","transfer_amount":3000000,"bank_branch":"Virtual Account","account_holder_name":"YOUR COMPANY","identity_amount":0},{"bank_code":"BRI","collection_type":"POOL","bank_account_number":"2621545825240","transfer_amount":3000000,"bank_branch":"Virtual Account","account_holder_name":"YOUR COMPANY","identity_amount":0},{"bank_code":"BNI","collection_type":"POOL","bank_account_number":"880845684047","transfer_amount":3000000,"bank_branch":"Virtual Account","account_holder_name":"YOUR COMPANY","identity_amount":0},{"bank_code":"PERMATA","collection_type":"POOL","bank_account_number":"821447574437","transfer_amount":3000000,"bank_branch":"Virtual Account","account_holder_name":"YOUR COMPANY","identity_amount":0}],"available_ewallets":[],"should_exclude_credit_card":false,"should_send_email":false,"created":"2019-02-20T07:48:29.649Z","updated":"2019-02-20T07:48:29.649Z"}
        }
    },
    mounted() {
        this.buttonLabel = this.label
        this.amountFinal = this.amount
    },
    methods: {
        donate() {
            if (!confirm('Anda yakin akan melakukan donasi?')) return;

            let data = {
                program_id: this.program,
                program_package_id: this.package,
                amount: this.amountFinal,
                remark: this.remark
            }
            
            this.disabled = true
            this.buttonLabel = 'Mohon tunggu...'
            // simpan di database
            axios.post(BASE_URL + '/donation', data).then(r => {
                this.buttonLabel = this.label
                this.disabled = false
                console.log(r)
                if (r.data.error_code) {
                    alert('Terjadi kesalahan. ' + r.data.error_code + ' ' + r.data.message)
                    return
                }
                this.xenditResponse = r.data
            }).catch(e => {
                this.buttonLabel = this.label
                this.disabled = false
                console.log(e)
            })
        }
    }
}
</script>

<style scoped>

.amount, 
.time, 
.account-number, 
.account-name {
    font-weight: bold;
    color: red;
    font-size: 16px;
}

</style>