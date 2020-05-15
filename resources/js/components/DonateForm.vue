<template>
  <div>
    <div v-if="xenditResponse && !disabled">
      <!-- <a :href="xenditResponse.invoice_url" class="btn btn-primary">INVOICE</a> -->
      <PaymentForm
        :amount="xenditResponse.amount"
        :description="xenditResponse.description"
        :externalid="xenditResponse.external_id"
        :expiry="xenditResponse.expiry_date"
      />
    </div>
    <div v-if="disabled" class="text-center">{{lang[locale]['pleaseWait']}}</div>
    <div v-if="!xenditResponse && !disabled">
      <!-- <h3>Informasi Donatur</h3> -->
      <el-form label-width="130px" label-position="top">
        <el-form-item
          :label="lang[locale]['Nama Donatur']"
          :style="locale == 'ar' ? 'text-align: right;' : ''"
        >
          <el-input :placeholder="lang[locale]['Nama Donatur']" v-model="user.name">
            <el-select
              v-model="user.gender"
              :slot="'prepend'"
              style="width:100px"
              :placeholder="lang[locale]['pilih']"
            >
              <el-option
                v-for="item in genderOptions[locale]"
                :key="item.label"
                :label="item.label"
                :value="item.label"
              >
                <font-awesome-icon :icon="item.icon"></font-awesome-icon>
                {{item.label}}
              </el-option>
            </el-select>
          </el-input>
          <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
        </el-form-item>
        <el-form-item
          :label="lang[locale]['Phone']"
          :style="locale == 'ar' ? 'text-align: right' : ''"
        >
          <el-input :placeholder="lang[locale]['Phone']" v-model="user.phone">
            <el-select
              :placeholder="lang[locale]['negara']"
              v-model="country"
              slot="prepend"
              style="width:150px"
              filterable
            >
              <el-option
                v-for="item in countries.filter(c => !!c.name_ar).sort((a, b) => parseInt(a.dial_code) - parseInt(b.dial_code))"
                :key="item.code"
                :label="'[' + item.dial_code + '] ' + (locale == 'ar' ? item.name_ar : item.name)"
                :value="item.dial_code"
              >[{{item.dial_code}}] {{locale == 'ar' ? item.name_ar : item.name}}</el-option>
            </el-select>
          </el-input>
          <div class="el-form-item__error" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
        </el-form-item>
        <el-form-item
          :label="lang[locale]['Email']"
          :style="locale == 'ar' ? 'text-align: right;direction: rtl' : ''"
        >
          <el-input :placeholder="lang[locale]['Email']" v-model="user.email"></el-input>
          <div class="el-form-item__error" v-if="formErrors.email">{{formErrors.email[0]}}</div>
        </el-form-item>
      </el-form>
      <p :style="locale == 'ar' ? 'text-align: right' : ''">{{lang[locale]['enterAmount']}}</p>
      <el-row :gutter="5">
        <el-col :span="7">
          <el-input type="number" v-model="data.price" :disabled="!data.flexible_amount"></el-input>
        </el-col>
        <el-col :span="5">
          <span style="line-height:40px">USD</span>
        </el-col>
        <el-col :span="12">
          <el-input-number
            :disabled="!data.allow_multiple"
            style="width:100%"
            v-model="qty"
            :step="data.multiple_step"
            :min="data.minimum_qty"
          ></el-input-number>
        </el-col>
      </el-row>
      <br />
      <p
        :style="locale == 'ar' ? 'text-align: right;direction: rtl' : ''"
      >{{lang[locale]['enterAdditionalInfo']}}</p>
      <textarea class="form-control" rows="3" v-model="additionalRemark"></textarea>
      <br />
      <ul class="list-group list-group-flush">
        <li class="list-group-item text-right" v-for="(p, i) in data.prices" :key="i">
          <h3>
            <span v-if="locale == 'ar'">
              <!-- {{formatNumber(p.price  * qty).toArabicDigits()}}  -->
              <small style="display:inline-block">{{p.currency.description}}</small>
              {{(p.price * qty).toFixed(2) | formatNumber}}
            </span>
            <span v-else>
              <small style="display:inline-block">{{p.currency.currency}}</small>
              {{(p.price * qty).toFixed(2) | formatNumber}}
            </span>
            <img
              v-if="!!p.currency.flag_image"
              :src="p.currency.flag_image"
              alt
              style="border:1px solid #ddd;width:50px;height:30px;"
            />
          </h3>
        </li>
      </ul>
      <br />
      <button
        v-show="!xenditResponse"
        :disabled="disabled"
        class="btn btn-block btn-primary btn-lg"
        @click="donate"
        style="border-radius:30px"
      >{{buttonLabel}}</button>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import PaymentForm from "./PaymentForm";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faMale, faFemale } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Countries from "./Countries";
library.add(faMale, faFemale);

export default {
  components: { PaymentForm, FontAwesomeIcon, Countries },
  watch: {
    "data.price"(v, o) {
      this.qty = (v / this.harga_satuan).toFixed(2);
    }
  },
  props: ["paket", "label"],
  filters: {
    readableDateTime(v) {
      return moment(v).format("DD MMM YYYY HH:mm");
    }
  },
  computed: {
    amountFinal() {
      // cari rate dalam rupiah
      return this.data.price * parseFloat(this.idr_rate.rate) * this.qty;
    }
  },
  data() {
    return {
      locale: LOCALE,
      disabled: false,
      buttonLabel: "",
      xenditResponse: null,
      additionalRemark: "",
      data: {},
      qty: 0,
      harga_satuan: 0,
      currencies: [],
      idr_rate: { currency: "IDR", rate: 15000 },
      user: { name: "", email: "", phone: "" },
      formErrors: {},
      countries: Countries,
      country: "",
      genderOptions: {
        id: [
          { label: "Hamba Allah", icon: "male" },
          { label: "Hamba Allah", icon: "female" }
        ],
        en: [
          { label: "Servant of Allah", icon: "male" },
          { label: "Servant of Allah", icon: "female" }
        ],
        ar: [
          { label: "فاعل خير", icon: "male" },
          { label: "فاعلة خير", icon: "female" }
        ]
      },
      lang: {
        id: {
          negara: "Negara",
          pilih: "Pilih",
          pleaseWait: "Mohon tunggu...",
          "Nama Donatur": "Nama Donatur*",
          Email: "Email",
          Phone: "No. HP*",
          enterAmount: "Masukkan jumlah yang akan Anda donasikan (USD)",
          enterAdditionalInfo:
            "Tulis keterangan tambahan jika ada. Untuk program masjid, sumur, dan mujamma' ta'limi tuliskan nama yang akan dicantumkan di prasasti",
          enterPhone: "Mohon isi no. HP",
          andaYakin: "Apakah anda yakin?",
          mohonTunggu: "Mohon Tunggu",
          enterName: "Mohon isi nama Anda"
        },
        en: {
          negara: "Country",
          pilih: "Select",
          pleaseWait: "Please wait...",
          "Nama Donatur": "Donor Name*",
          Email: "Email",
          Phone: "Phone*",
          enterAmount: "Enter amount (USD)",
          enterAdditionalInfo: "Enter additional information if any.",
          enterPhone: "Please enter phone number",
          andaYakin: "Are you sure?",
          mohonTunggu: "Please wait a moment",
          enterName: "Please enter your name"
        },
        ar: {
          negara: "الدولة",
          pilih: "اختر",
          pleaseWait: "فضلا انتظر لحظة ...",
          "Nama Donatur": "اسم المتبرع*",
          Email: "البريد الإلكتروني",
          Phone: "رقم الواتساب*",
          enterAmount: "ادخل قيمة تبرع",
          enterAdditionalInfo:
            "اختر الاسم الذي ترغب أن يكتب في اللوحة الرخامية (خاص بالمجمعات التعلمية و المساجد والابار)",
          enterPhone: "يرجى إدخال رقم الهاتف",
          andaYakin: "هل أنت واثق؟",
          mohonTunggu: "فضلا انتظر لحظة",
          enterName: "من فضلك أدخل إسمك"
        }
      }
    };
  },
  mounted() {
    this.buttonLabel = this.label;
    this.getData();
    axios
      .get(BASE_URL + "/currencyRate")
      .then(r => {
        this.currencies = r.data;
        this.idr_rate = r.data.find(d => d.currency == "IDR");
      })
      .catch(e => console.log(e));
  },
  methods: {
    // formatNumber(v) {
    //     try {
    //         v += '';
    //         var x = v.split('.');
    //         var x1 = x[0];
    //         var x2 = x.length > 1 ? '.' + x[1] : '';
    //         var rgx = /(\d+)(\d{3})/;
    //         while (rgx.test(x1)) {
    //             x1 = x1.replace(rgx, '$1' + ',' + '$2');
    //         }
    //         return x1 + x2;
    //     } catch (error) {
    //         return 0
    //     }
    // },
    getData() {
      axios
        .get(BASE_URL + "/programPackage/" + this.paket)
        .then(r => {
          this.data = r.data;
          this.harga_satuan = r.data.price;
          this.qty = r.data.multiple_step;
        })
        .catch(e => console.log(e));
    },
    donate() {
      if (!this.user.name) {
        // this.$message({
        //     message: this.lang[this.locale]['enterName'],
        //     type: 'error',
        //     showClose: true
        // });

        // return;
        this.user.name = "No name";
      }

      if (!this.user.phone) {
        // this.$message({
        //     message: this.lang[this.locale]['enterPhone'],
        //     type: 'error',
        //     showClose: true
        // });

        // return;
        this.user.phone = "000";
      }

      if (!this.user.email) {
        this.user.email = "mail@dummy.com";
      }

      // kalau sumur, masjid, mujamma
      let programName = this.data.program.name_id.toLowerCase();
      if (
        programName.includes("pembangunan masjid") ||
        programName.includes("sumur") ||
        programName.includes("mujamma")
      ) {
        if (!this.additionalRemark) {
          this.$message({
            message: this.lang[this.locale]["enterAdditionalInfo"],
            type: "error",
            showClose: true
          });

          return;
        }
      }

      if (!confirm(this.lang[this.locale]["andaYakin"])) {
        return;
      }

      let data = {
        program_id: this.data.program_id,
        program_package_id: this.data.id,
        amount: this.amountFinal,
        qty: this.qty,
        remark:
          this.data.program.name +
          " - " +
          this.data.name +
          " : " +
          this.additionalRemark,
        name: this.user.gender + " " + this.user.name,
        phone: this.country + this.user.phone,
        email: this.user.email
      };

      this.disabled = true;
      this.buttonLabel = this.lang[this.locale]["mohonTunggu"] + "...";
      // simpan di database
      axios
        .post(BASE_URL + "/donation", data)
        .then(r => {
          this.buttonLabel = this.label;
          this.disabled = false;
          if (r.data.error_code) {
            this.$message({
              message: "ERROR. " + r.data.error_code + " " + r.data.message,
              type: "error",
              showClose: true
            });
            return;
          }
          this.xenditResponse = r.data;
        })
        .catch(e => {
          this.buttonLabel = this.label;
          this.disabled = false;
          if (e.response.status == 422) {
            this.formErrors = e.response.data.errors;
          }

          if (e.response.status == 500) {
            this.formErrors = {};
            this.$message({
              message: e.response.data,
              type: "error",
              showClose: true
            });
          }
        });
    }
  }
};
</script>

<style scoped>
.attention {
  background: yellow;
  padding: 0 10px;
}
</style>
