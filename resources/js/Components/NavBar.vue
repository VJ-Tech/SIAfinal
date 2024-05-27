<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="mainDiv">
        <Link href="/" class="buttons" :class="{ active: $page.url === '/' }">
            <img src="../Components/home.png" alt="">
            <p>Home</p>
        </Link>
        <Link href="/Csv" class="buttons" :class="{ active: $page.url === '/Csv' }">
            <img src="../Components/csv.png" alt="">
            <p>Csv</p>
        </Link>
        <Link href="/QRCode" class="buttons" :class="{ active: $page.url === '/QRCode' }">
            <img src="../Components/qr-code.png" alt="">
            <p>QR</p>
        </Link>
        <Link href="/Pdf" class="buttons" :class="{ active: $page.url === '/Pdf' }">
            <img src="../Components/pdf-file.png" alt="">
            <p>Pdf</p>
        </Link>
    </div>
</template>


<style scoped>
img {
    width: 40px;
    height: 40px;
}

p {
    font-weight: bold;
    text-align: center;
}

.buttons {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border-radius: 20px;
}

.buttons:hover {
    background-color: bisque;
}

.mainDiv {
    display: flex;
    gap: 50px;
    padding: 10px;
    border-radius: 20px;
    background-color: beige;
}

.active {
    background-color:bisque;
}
</style>
