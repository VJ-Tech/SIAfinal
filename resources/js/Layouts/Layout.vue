<script setup>
import NavBar from '../Components/NavBar.vue';
</script>

<template>
    <div class="mainLayoutDiv">
        <nav>
            <NavBar/>
        </nav>
        <div class="content">
            <slot/>
        </div>
    </div>
</template>

<style scoped>
.mainLayoutDiv {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

nav {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.content {
    flex: 1;
    padding: 20px;
}
</style>
