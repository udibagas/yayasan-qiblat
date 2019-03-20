<template>
    <div>
        <div v-if="xenditResponse">
            <iframe :src="xenditResponse.invoice_url" frameborder="0" style="width:100%;height:700px;"></iframe>
        </div>
        <div v-if="!xenditResponse" v-loading="disabled">
            <!-- <h3>Informasi Donatur</h3> -->
            <el-form label-width="130px" label-position="left">
                <el-form-item :label="lang[locale]['Nama Donatur']">
                    <el-input disabled v-model="user.name"></el-input>
                </el-form-item>
                <el-form-item :label="lang[locale]['Email']">
                    <el-input disabled v-model="user.email"></el-input>
                </el-form-item>
                <el-form-item :label="lang[locale]['Phone']">
                    <el-input v-model="user.phone"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
                </el-form-item>
            </el-form>
            <p><i>{{lang[locale]['enterAmount']}}:</i></p>
            <el-row :gutter="15">
                <el-col :span="12">
                    <el-input type="number" v-model="data.price" :disabled="!data.flexible_amount"></el-input>
                </el-col>
                <el-col :span="12">
                    <el-input-number style="width:100%" v-model="qty" :min="1"></el-input-number>
                </el-col>
            </el-row><br>
            <p><i>{{lang[locale]['enterAdditionalInfo']}}:</i></p>
            <textarea class="form-control" rows="3" v-model="additionalRemark"></textarea>
            <!-- <div class="attention">Untuk program masjid, sumur, dan mujamma' ta'limi tuliskan nama yang akan dicantumkan di prasasti</div> -->
            <br>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-right" v-for="(c, i) in currencies" :key="i">
                    <h3>
                        {{c.rate * data.price  * qty | formatNumber}} <small>{{c.currency}}</small>
                        <img :src="'/img/currency/' + c.currency +'.jpeg'" alt="" style="border:1px solid #ddd;">
                    </h3>
                </li>
            </ul>
            <br>
            <button v-show="!xenditResponse" :disabled="disabled" class="btn btn-block btn-primary btn-lg" @click="donate" style="border-radius:30px">{{buttonLabel}}</button>
        </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    props: ['paket', 'label'],
    filters: {
        readableDateTime(v) {
            return moment(v).format('DD MMM YYYY HH:mm')
        }
    },
    computed: {
        amountFinal() {
            // cari rate dalam rupiah
            return this.data.price * parseFloat(this.idr_rate.rate) * this.qty
        }
    },
    data() {
        return {
            locale: LOCALE,
            disabled: false,
            buttonLabel: '',
            xenditResponse: null,
            additionalRemark: '',
            qty: 1,
            data: {},
            currencies: [],
            idr_rate: { currency: 'IDR', rate: 15000 },
            user: USER,
            formErrors: {},
            lang: {
                id: {
                    "Nama Donatur": "Nama Donatur",
                    "Email": "Email",
                    "Phone": "No. HP",
                    "enterAmount": "Masukkan jumlah yang akan Anda donasikan (USD)",
                    "enterAdditionalInfo": "Tulis keterangan tambahan jika ada. Untuk program masjid, sumur, dan mujamma' ta'limi tuliskan nama yang akan dicantumkan di prasasti",
                    "enterPhone": "Mohon isi no. HP",
                    "andaYakin": "Apakah anda yakin?",
                    "mohonTunggu": "Mohon Tunggu"
                },
                en: {
                    "Nama Donatur": "Donor Name",
                    "Email": "Email",
                    "Phone": "Phone",
                    "enterAmount": "Enter amount (USD)",
                    "enterAdditionalInfo": "Enter additional information if any.",
                    "enterPhone": "Please enter phone number",
                    "andaYakin": "Are you sure?",
                    "mohonTunggu": "Please wait a moment"
                },
                ar: {
                    "Nama Donatur": "اسم المانحة",
                    "Email": "البريد الإلكتروني",
                    "Phone": "رقم الجوال / الوتساب",
                    "enterAmount": "ادخل قيمة المبلغ تبرعتك",
                    "enterAdditionalInfo": "اكتب معلومات إضافية ( خاص مشروع جامع وآبار ومركز التعليمي اكتب اسم الذي سيظهر في رخام المشروع )",
                    "enterPhone": "يرجى إدخال رقم الهاتف",
                    "andaYakin": "هل أنت واثق؟",
                    "mohonTunggu": "فضلا انتظر لحظة"
                },
            }
        }
    },
    mounted() {
        this.buttonLabel = this.label
        this.getData()
        axios.get(BASE_URL + '/currencyRate').then(r => {
            this.currencies = r.data
            this.idr_rate = r.data.find(d => d.currency == 'IDR')
        }).catch(e => console.log(e))
    },
    methods: {
        getData() {
            axios.get(BASE_URL + '/programPackage/' + this.paket).then(r => {
                this.data = r.data
            }).catch(e => console.log(e))
        },
        donate() {
            if (!this.user.phone) {
                this.$message({
                    message: this.lang[this.locale]['enterPhone'],
                    type: 'error',
                    showClose: true
                });

                return;
            }

            // kalau sumur, masjid, mujamma
            let programName = this.data.program.name_id.toLowerCase()
            if (programName.includes('pembangunan masjid') || programName.includes('sumur') || programName.includes('mujamma')) {
                if (!this.additionalRemark) {
                    this.$message({
                        message: this.lang[this.locale]['enterAdditionalInfo'],
                        type: 'error',
                        showClose: true
                    });
    
                    return;
                }
            }


            this.$confirm(this.lang[this.locale]['andaYakin'], 'Confirm').then(() => {
                let data = {
                    program_id: this.data.program_id,
                    program_package_id: this.data.id,
                    amount: this.amountFinal,
                    qty: this.qty,
                    remark: this.data.program.name_id + ' - ' + this.data.name_id + ' : ' + this.additionalRemark,
                    phone: this.user.phone
                }
                
                this.disabled = true
                this.buttonLabel = this.lang[this.locale]['mohonTunggu'] + '...'
                // simpan di database
                axios.post(BASE_URL + '/donation', data).then(r => {
                    this.buttonLabel = this.label
                    this.disabled = false
                    if (r.data.error_code) {
                        this.$message({
                            message: 'ERROR. ' + r.data.error_code + ' ' + r.data.message,
                            type: 'error',
                            showClose: true
                        })
                        return
                    }
                    this.xenditResponse = r.data
                }).catch(e => {
                    this.buttonLabel = this.label
                    this.disabled = false
                    if (e.response.status == 422) {
                        this.formErrors = e.response.data.errors;
                    }

                    if (e.response.status == 500) {
                        this.formErrors = {}
                        this.$message({
                            message: e.response.data,
                            type: 'error',
                            showClose: true
                        })
                    }
                })

            }).catch(e => console.log(e))
        }
    }
}
</script>

<style scoped>
.attention {
    background: yellow;
    padding: 0 10px;
}
</style>