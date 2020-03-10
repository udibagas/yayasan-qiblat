<template>
    <div>
        <div class="text-center alert alert-info" v-if="!!waiting">{{waiting}}</div>
        <div v-if="done">
            <Acknowledgement :lang="locale" />
        </div>
        <el-form v-show="!success">
            <div class="text-center" style="background-color:#158682;color:#fff;margin-bottom:20px;padding:20px;">
                <el-row style="border-top:1px solid #bbb;border-bottom:1px solid #bbb;margin:20px 0;padding:10px 0;">
                    <el-col :span="6" style="padding:10px 0;border-right:1px solid #bbb;">
                        <h3>{{day}}</h3>
                        {{lang[locale].hari}}
                    </el-col>
                    <el-col :span="6" style="padding:10px 0;border-right:1px solid #bbb;">
                        <h3>{{hour}}</h3>
                        {{lang[locale].jam}}
                    </el-col>
                    <el-col :span="6" style="padding:10px 0;border-right:1px solid #bbb;">
                        <h3>{{minute}}</h3>
                        {{lang[locale].menit}}
                    </el-col>
                    <el-col :span="6" style="padding:10px 0;">
                        <h3>{{second}}</h3>
                        {{lang[locale].detik}}
                    </el-col>
                </el-row>

                <h2>Rp. {{amount | formatNumber}}</h2>
                <strong>{{description}}</strong>
            </div>

            <el-form-item>
                <el-input :placeholder="lang[locale].nomor_kartu" v-model="card_number"></el-input>
                <div class="el-form-item__error" v-if="!!formErrors.card_number">{{formErrors.card_number}}</div>
            </el-form-item>
            <el-form-item>
                <el-row :gutter="15">
                    <el-col :span="12">
                        <el-select v-model="card_exp_month" :placeholder="lang[locale].bulan" style="width:100%">
                            <el-option v-for="(m,i) in months" :key="i" :value="m.value" :label="m.label"></el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="12">
                        <el-select v-model="card_exp_year" :placeholder="lang[locale].tahun" style="width:100%">
                            <el-option v-for="y in years" :key="y" :value="y" :label="y"></el-option>
                        </el-select>
                    </el-col>
                </el-row>
                <div class="el-form-item__error" v-if="!!formErrors.card_exp_year">{{formErrors.card_exp_year}}</div>
            </el-form-item>
            <el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-input type="password" placeholder="CVC/CVV" v-model="card_cvn"></el-input>
                    </el-col>
                    <el-col :span="16" class="text-right">
                        <img src="https://invoice-staging.xendit.co/static/img/visa_logo.png" style="height:35px;margin-right:15px" alt="">
                        <img src="https://invoice-staging.xendit.co/static/img/mastercard_logo.png" style="height:35px" alt="">
                    </el-col>
                </el-row>
                <span>{{lang[locale].code_behinde_card}}</span>
                <div class="el-form-item__error" v-if="!!formErrors.card_cvn">{{formErrors.card_cvn}}</div>
            </el-form-item>
            <div class="alert alert-danger" v-if="error">{{error}}</div>
            <el-form-item>
                <button :disabled="!!waiting" class="btn btn-block btn-primary btn-lg" @click.prevent="submitForm" style="border-radius:30px">{{lang[locale].submit}}</button>
            </el-form-item>
        </el-form>

        <iframe @unload="pay" v-show="payer_authentication_url" :src="payer_authentication_url" frameborder="0" style="width:100%;height:370px;"></iframe>
    </div>
</template>

<script>
import Acknowledgement from './Acknowledgement'
import moment from 'moment'

export default {
    props: ['amount', 'description', 'externalid', 'expiry'],
    components: { Acknowledgement },
    data() {
        return {
            day: 0,
            hour: 0,
            minute: 0,
            second: 0,
            success: false,
            done: false,
            locale: LOCALE,
            card_number: '',
            card_exp_month: null,
            card_exp_year: null,
            card_cvn: null,
            error: null,
            formErrors: {},
            years: [],
            payer_authentication_url: '',
            token: '',
            waiting: '',
            months: [
                {value: '01', label: 'January'},
                {value: '02', label: 'February'},
                {value: '03', label: 'March'},
                {value: '04', label: 'April'},
                {value: '05', label: 'May'},
                {value: '06', label: 'June'},
                {value: '07', label: 'July'},
                {value: '08', label: 'August'},
                {value: '09', label: 'September'},
                {value: '10', label: 'October'},
                {value: '11', label: 'November'},
                {value: '12', label: 'December'},
            ],
            lang: {
                id: {
                    tahun: 'Tahun',
                    bulan: 'Bulan',
                    hari: 'Hari',
                    jam: 'Jam',
                    menit: 'Menit',
                    detik: 'Detik',
                    nomor_kartu: 'Nomor Kartu',
                    code_behind_card: '3 atau 4 digit kode di belakang kartu',
                    submit: 'BAYAR SEKARANG',
                    mohonTunggu: 'Mohon tunggu...',
                },
                en: {
                    tahun: 'Year',
                    bulan: 'Month',
                    hari: 'Day',
                    jam: 'Hour',
                    menit: 'Minute',
                    detik: 'Second',
                    nomor_kartu: 'Card Number',
                    code_behind_card: '3 or 4 digit code behind the card',
                    submit: 'PAY NOW',
                    mohonTunggu: 'Please wait...',
                },
                ar: {
                    tahun: 'سنة',
                    bulan: 'شهر',
                    hari: 'يوم',
                    jam: 'ساعة',
                    menit: 'دقيقة',
                    detik: 'ثانية',
                    nomor_kartu: 'رقم بطاقة',
                    code_behind_card: '٣ أو ٤ رقم سر خلف البطاقة',
                    submit: 'دفع الآن',
                    mohonTunggu: 'فضلا انتظر لحظة',
                }
            }
        }
    },
    mounted() {
        let now = new Date()
        let year = now.getFullYear()
        for (let i = 0; i <= 10; i++) {
            this.years.push(year + i)
        }

        let expiry_date = moment(this.expiry);

        setInterval(() => {
            let now = moment()
            let duration = moment.duration(expiry_date.diff(now))
            this.day = duration.days()
            this.hour = duration.hours()
            this.minute = duration.minutes()
            this.second = duration.seconds()
        }, 1000)
    },
    methods: {
        pay() {
            this.waiting = this.lang[this.locale].mohonTunggu
            let data = {
                external_id: this.externalid,
                token_id: this.token,
                amount: this.amount
            }
            axios.post(BASE_URL + '/donation/pay', data).then(r => {
                this.done = true
                console.log(r)
            }).catch(e => {
                console.log(e)
            }).finally(() => {
                this.waiting = ''
            })
        },
        submitForm() {
            if (!Xendit.card.validateCardNumber(this.card_number.replace(/-/g, ''))) {
                this.formErrors.card_number = 'Invalid card number'
                this.$forceUpdate()
                return
            }

            if (!Xendit.card.validateExpiry(this.card_exp_month, this.card_exp_year)) {
                this.formErrors.card_exp_year = 'Invalid expiry month / year'
                this.$forceUpdate()
                return
            }

            if (!Xendit.card.validateCvn(this.card_cvn)) {
                this.formErrors.card_cvn = 'Invalid CVC/CVV'
                this.$forceUpdate()
                return
            }

            Xendit.card.createToken({
                amount: this.amount,
                card_number: this.card_number.replace(/-/g, ''),
                card_exp_month: this.card_exp_month,
                card_exp_year: this.card_exp_year + '',
                card_cvn: this.card_cvn,
                is_multiple_use: false
            }, this.xenditResponseHandler);
        },
        xenditResponseHandler(err, creditCardCharge) {
            console.log(creditCardCharge, err)
            if (err) {
                this.error = err.message
                return;
            }

            if (creditCardCharge.status === 'VERIFIED') {
                this.token = creditCardCharge.id
                this.payer_authentication_url = null;
                this.success = true
                this.pay()
            } else if (creditCardCharge.status === 'IN_REVIEW') {
                this.payer_authentication_url = creditCardCharge.payer_authentication_url
                this.success = true
            } else if (creditCardCharge.status === 'FAILED') {
                this.error = creditCardCharge.failure_reason
            }
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
