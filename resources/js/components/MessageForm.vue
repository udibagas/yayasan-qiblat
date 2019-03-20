<template>
    <div class="message-form">
        <el-popover
        v-model="visible"
        placement="top"
        width="350"
        trigger="click">
            <el-card>
                <div slot="header" class="clearfix">
                    <span>Please ask me question</span>
                    <el-button style="float: right; padding: 3px 0" type="text" @click="visible = false">
                        <i class="el-icon-circle-close"></i>
                    </el-button>
                </div>
                <p class="message"><strong>Admin:</strong> May I help you?</p>
                <br>
                <br>
                <br>
                <br>
                <el-row>
                    <el-col :span="20">
                        <input class="message-input" placeholder="Your Message" v-model="text"></input>
                    </el-col>
                    <el-col :span="4" class="text-right">
                        <el-button type="primary" icon="fab fa-telegram-plane" circle @click="sendMessage"></el-button>
                    </el-col>
                </el-row>
            </el-card>
            
            <el-button type="primary" slot="reference" icon="fab fa-whatsapp" round> Send Message</el-button>
        </el-popover>
    </div>
</template>

<script>
export default {
    props: ['phone'],
    data() {
        return {
            text: '',
            visible: false
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