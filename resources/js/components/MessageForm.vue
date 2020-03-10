<template>
    <div class="message-form" :style="locale == 'ar' ? 'direction:rtl'  : ''">
        <el-popover
        v-model="visible"
        placement="top"
        width="350"
        trigger="click">
            <el-card>
                <div slot="header" class="clearfix">
                    <span>{{labels.silakan_tanya[locale]}}</span>
                    <el-button style="float: right; padding: 3px 0" type="text" @click="visible = false">
                        <i class="el-icon-circle-close"></i>
                    </el-button>
                </div>
                <p class="message" :style="locale == 'ar' ? 'direction:rtl'  : ''">{{labels.default_message[locale]}}</p>
                <br> <br> <br> <br>
                <el-row>
                    <el-col :span="20">
                        <input :style="locale == 'ar' ? 'direction:rtl'  : ''" class="message-input" :placeholder="labels.pesan_anda[locale]" v-model="text">
                    </el-col>
                    <el-col :span="4" class="text-right">
                        <el-button type="primary" icon="fab fa-telegram-plane" circle @click="sendMessage"></el-button>
                    </el-col>
                </el-row>
            </el-card>

            <el-button type="primary" slot="reference" icon="fab fa-whatsapp" round> {{labels.kirim_pesan[locale]}}</el-button>
        </el-popover>
    </div>
</template>

<script>
export default {
    props: ['phone', 'locale'],
    data() {
        return {
            text: '',
            visible: false,
            labels: {
                silakan_tanya: {
                    id: 'Silakan Bertanya Kepada Kami',
                    en: 'Please ask me question',
                    ar: 'من فضلك اسألني سؤال'
                },
                default_message: {
                    id: 'Admin: Ada yang bisa kami bantu?',
                    en: 'Admin: May I help you?',
                    ar: 'خدمة العملاء : هل يمكنني مساعدتك في شيء ما؟'
                },
                pesan_anda: {
                    id: 'Pesan Anda',
                    en: 'Your message',
                    ar: 'اكتب هنا'
                },
                kirim_pesan: {
                    id: 'Kirim Pesan',
                    en: 'Send Message',
                    ar: 'خدمة العملاء'
                }
            }
        }
    },
    methods: {
        sendMessage() {
            this.visible = false
            let wa_api_url = 'https://api.whatsapp.com/send?phone=' + this.phone + '&text=' + this.text
            window.open(wa_api_url, '_blank')
        }
    }
}
</script>

<style scoped>
.message-form {
    position: fixed;
    bottom: 10px;
    right: 10px;
}

p.message {
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 20px;
    background: #fff;
}

.message-input {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 20px;
    width: 100%;
}
</style>
