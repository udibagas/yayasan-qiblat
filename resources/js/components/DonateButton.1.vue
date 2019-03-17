<template>
    <div>
        <hr>
        <div v-if="xenditResponse">
            <!-- <h1>Terimakasih!</h1>
            <p>
                Terimakasih atas donasi Anda. Silakan transfer ke bank berikut sejumlah 
                <span class="amount">Rp {{xenditResponse.amount | formatNumber}}</span> 
                sebelum <span class="time">{{ xenditResponse.expiry_date | readableDateTime }} WIB</span>  :
            </p>
            
            <ul>
                <li v-for="b in xenditResponse.available_banks" :key="b.bank_code">
                    <h5 class="bank-code"> {{b.bank_code}} </h5>
                    Nomor Virtual Account <span class="account-number">{{b.bank_account_number}}</span> <br>
                    A.n <span class="account-name">{{b.account_holder_name}}</span>
                    <hr>
                </li>

            </ul> -->
            <iframe :src="xenditResponse.invoice_url" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
        <div v-if="!xenditResponse">
            <p><i>Masukkan jumlah yang akan Anda donasikan:</i></p>
            <input type="number" v-model="amountFinal" class="form-control input-lg" :disabled="!flexible"><br>
            <p><i>Tulis keterangan tambahan jika ada:</i></p>
            <textarea class="form-control" rows="3" v-model="additionalRemark" placeholder="Keterangan"></textarea><br>
            <button v-show="!xenditResponse" :disabled="disabled" class="btn btn-block btn-primary btn-lg" @click="donate">{{buttonLabel}}</button>
        </div>
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
            amountFinal: 0,
            additionalRemark: '',
            // xenditResponse: {
            //     "id": "59d4c981997f96da6b69d24a",
            //     "external_id": "demo-1475801962607",
            //     "user_id": "59d4c95053db7ba6123971b1",
            //     "status": "PENDING",
            //     "merchant_name": "Xendit",
            //     "merchant_profile_picture_url": "https://du8nwjtfkinx.cloudfront.net/xendit.png",
            //     "amount": 13000,
            //     "payer_email": "sample_email@xendit.co",
            //     "description": "Trip to Bali",
            //     "expiry_date": "2017-10-05T11:44:00.736Z",
            //     "invoice_url": "https://invoice-staging.xendit.co/web/invoices/57f6f439b33bed606c4dae86",
            //     "available_banks": [
            //         {
            //             "bank_code": "MANDIRI",
            //             "collection_type": "POOL",
            //             "bank_account_number": "88464100767",
            //             "transfer_amount": 13000,
            //             "bank_branch": "Virtual Account",
            //             "account_holder_name": "XENDIT",
            //             "identity_amount": 0
            //         },
            //         {
            //             "bank_code": "BCA",
            //             "collection_type": "POOL",
            //             "bank_account_number": "02938103212",
            //             "transfer_amount": 13000,
            //             "bank_branch": "Virtual Account",
            //             "account_holder_name": "XENDIT",
            //             "identity_amount": 0
            //         },
            //         {
            //             "bank_code": "BNI",
            //             "collection_type": "POOL",
            //             "bank_account_number": "26215100282",
            //             "transfer_amount": 13000,
            //             "bank_branch": "Virtual Account",
            //             "account_holder_name": "XENDIT",
            //             "identity_amount": 0
            //         },
            //         {
            //             "bank_code": "BRI",
            //             "collection_type": "POOL",
            //             "bank_account_number": "8808104859",
            //             "transfer_amount": 13000,
            //             "bank_branch": "Virtual Account",
            //             "account_holder_name": "XENDIT",
            //             "identity_amount": 0
            //         }
            //     ],
            //     "available_retail_outlets": [
            //         {
            //             "retail_outlet_name": "ALFAMART",
            //             "payment_code": "ALFA123456",
            //             "transfer_amount": 54000
            //         }
            //     ],
            //     "should_exclude_credit_card": false,
            //     "should_send_email": false,
            //     "created": "2017-10-04T11:44:01.137Z",
            //     "updated": "2017-10-04T11:44:01.137Z"
            // }
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
                remark: this.remark + ' : ' + this.additionalRemark
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