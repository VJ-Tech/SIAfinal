<template>
    <h1>Pdf</h1>
    <div>
        <button @click="generatePDF">Generate PDF</button>
    </div>
</template>

<script setup>
    import Layout from '@/Layouts/Layout.vue'
    import { onMounted } from 'vue'

    defineOptions ({
        layout: Layout
    })

    const generatePDF = () => {
        window.location.href = '/generate-pdf';
    }

    onMounted(() => {
        console.log('Component mounted');
    })
</script>

<style scoped>
button {
    background-color: cyan;
    padding: 10px 20px;
    border-radius: 20px;
}
div {
    display: flex;
    justify-content: center;
}
    h1 {
        font-size: 40px;
        font-weight: bold;
    }
</style>
