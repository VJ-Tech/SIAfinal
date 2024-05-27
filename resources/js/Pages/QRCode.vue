<template>
    <div id="qrmaincon">
        <h1>QR Code Scanner & Generator</h1>
        <div class="qrContent">
            <label for="choosefile">Scan QR Code</label>
            <input type="file" @change="handleFileChange" id="choosefile" name="choosefile">
            <div v-if="qrCodeResult" id="qrresult">
                <p>{{ qrCodeResult }}</p>
            </div>
        </div>

        <div class="qrForm">
            <label for="qrText">Generate QR Code</label>
            <input type="text" v-model="qrText" id="qrText" name="qrText">
            <button @click="generateQRCode">Generate QR Code</button>
            <div v-if="qrGenerated" id="qrCodeDisplay">
                <img :src="qrImageUrl" alt="Generated QR Code">
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import Layout from '@/Layouts/Layout.vue'
import QRCode from 'qrcode'
import jsQR from 'jsqr'

defineOptions ({
    layout: Layout
})

const qrCodeResult = ref('')
const qrText = ref('')
const qrGenerated = ref(false)
const qrImageUrl = ref('')

const handleFileChange = (event) => {
    const file = event.target.files[0]
    const reader = new FileReader()

    reader.onload = (e) => {
        const image = new Image()
        image.onload = () => {
            const canvas = document.createElement('canvas')
            const ctx = canvas.getContext('2d')
            canvas.width = image.width
            canvas.height = image.height
            ctx.drawImage(image, 0, 0)
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height)
            const code = jsQR(imageData.data, imageData.width, imageData.height)
            if (code) {
                qrCodeResult.value = code.data
            } else {
                qrCodeResult.value = 'No QR code found in the image.'
            }
        }
        image.src = e.target.result
    }

    reader.readAsDataURL(file)
}

const generateQRCode = () => {
    if (qrText.value.trim() === '') {
        alert('Please enter some text to generate the QR code.')
        return
    }

    QRCode.toDataURL(qrText.value)
        .then(url => {
            qrImageUrl.value = url
            qrGenerated.value = true
        })
        .catch(error => {
            console.error('Error generating QR code:', error)
            alert('Error generating QR code. Please try again.')
        })
}
</script>

<style scoped>
label {
    font-weight: bold;
    color: blue;
}
.qrContent,
.qrForm {
    display: flex;
    align-items: center;
    flex-direction: column;
    margin-top: 20px;
}
#qrresult,
#qrCodeDisplay {
    margin-top: 20px;
    border: 1px solid green;
    padding: 20px;
}
h1 {
    font-size: 40px;
    font-weight: bold;
}

#qrmaincon {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
</style>
