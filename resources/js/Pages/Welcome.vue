<script setup>
import { ref } from 'vue'
import axios from 'axios'
import Layout from '@/Layouts/Layout.vue'

defineOptions({
    layout: Layout
})

const names = ref('')
const numberGroups = ref(2)
const generatedGroups = ref([])
const errorMessage = ref('')

const generateTeams = () => {
    errorMessage.value = ''
    const namesArray = names.value.split(',').map(name => name.trim()).filter(name => name !== '')
    const numGroups = parseInt(numberGroups.value)

    if (namesArray.length < numGroups) {
        errorMessage.value = 'Number of names must be greater than or equal to number of groups.'
        return
    }

    // Shuffle names
    for (let i = namesArray.length - 1; i > 0; i--) {
        const randomIndex = Math.floor(Math.random() * (i + 1))
        ;[namesArray[i], namesArray[randomIndex]] = [namesArray[randomIndex], namesArray[i]]
    }

    // Divide names into groups
    generatedGroups.value = []
    for (let i = 0; i < numGroups; i++) {
        generatedGroups.value.push([])
    }
    namesArray.forEach((name, index) => {
        generatedGroups.value[index % numGroups].push(name)
    })
}

const saveTeams = async () => {
    try {
        if (generatedGroups.value.length === 0) {
            errorMessage.value = 'No generated teams to save.';
            return;
        }

        const response = await axios.post('/groups', { groups: generatedGroups.value });
        console.log(response.data);
        errorMessage.value = ''; // Clear error message
        alert('Teams saved successfully');
    } catch (error) {
        console.error(error);
        errorMessage.value = error.response.data.error || 'Error saving teams.';
    }
}

</script>

<template>
    <div class="mainDivPage">
        <nav>
            <h1>Random Team Generator</h1>
            <form @submit.prevent="generateTeams">
                <label for="names">Enter Names (comma separated)</label>
                <input v-model="names" type="text" id="names" placeholder="Ex: victor, kairu, charles, rambo">
                <label for="numberGroups">Number of Groups</label>
                <input v-model="numberGroups" type="number" id="numberGroups" min="1">
                <button type="submit" id="generate">Generate Teams</button>
            </form>
            <button @click="saveTeams" id="savegroup">Save Teams</button>
            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </nav>
        <div class="pageContent">
            <div v-for="(group, index) in generatedGroups" :key="index" class="gengroup">
                <h3>Group {{ index + 1 }}</h3>
                <ul>
                    <li v-for="name in group" :key="name">{{ name }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
form {
    display: flex;
    flex-direction: column;
}
.mainDivPage {
    display: flex;
    flex-direction: row;
    height: 75vh;
    gap: 20px;
}
h1 {
    font-size: 40px;
    font-weight: bold;
}

nav{
    padding: 20px;
    background-color: blanchedalmond;
    border-radius: 30px;
}

.pageContent {
    border-radius: 20px;
    flex: 1;
    padding: 20px;
    background: rgba(128, 128, 128, 0.263);
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 20px;
}

.error {
    color: red;
}

#names {
    height: 100px;
}

#generate {
    background: cyan;
    border-radius: 5px;
}

button {
    margin: 10px;
}

input {
    border: none;
    border-radius: 20px;
    margin-bottom: 20px;
}

#savegroup {
    background: rgb(186, 186, 186);
    padding: 10px;
    border-radius: 5px;
}

.gengroup {
    background: rgb(173, 225, 230);
    padding: 20px;
    border-radius: 20px;
}

h3 {
    font-weight: bold;
    font-size: 20px;
}
</style>
