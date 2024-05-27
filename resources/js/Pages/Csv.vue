<template>
    <div>
        <div class="buttons">
            <button @click="downloadCsv" id="dlcsv">Download CSV</button>
            <input type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
            <button @click="$refs.fileInput.click()" id="upcsv">Upload CSV</button>
        </div>
        <div class="tableCsv">
            <h1>List</h1>
            <table v-if="groupedData.length > 0">
                <thead>
                    <tr>
                        <th v-for="header in tableHeaders" :key="header">{{ header }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in groupedData" :key="index">
                        <td v-for="(value, key) in row" :key="key">{{ value }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else>No data available</div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import Layout from '@/Layouts/Layout.vue'

defineOptions({
    layout: Layout
})

const groupedData = ref([])
const tableHeaders = ref([])

onMounted(() => {
    fetchGroupData()
})

const fetchGroupData = async () => {
    try {
        const response = await axios.get('/groups/all')
        groupedData.value = response.data
        // Set table headers based on the structure of fetched data
        setTableHeaders(response.data)
    } catch (error) {
        console.error(error)
        alert('Error fetching group data.')
    }
}

const downloadCsv = () => {
    // Create CSV content
    const csvContent = "data:text/csv;charset=utf-8,"
        + groupedData.value.map(row => Object.values(row).join(',')).join("\n")

    // Create a temporary link and trigger download
    const encodedUri = encodeURI(csvContent)
    const link = document.createElement('a')
    link.setAttribute('href', encodedUri)
    link.setAttribute('download', 'group_data.csv')
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
}

const handleFileUpload = (event) => {
    const file = event.target.files[0]
    const reader = new FileReader()

    reader.onload = (e) => {
        const csv = e.target.result
        const rows = csv.split('\n')
        const headers = rows[0].split(',')
        tableHeaders.value = headers.map(header => header.trim())

        const data = []

        for (let i = 1; i < rows.length; i++) {
            const columns = rows[i].split(',')
            if (columns.length > 0) {
                const rowData = {}
                for (let j = 0; j < columns.length; j++) {
                    rowData[tableHeaders.value[j]] = columns[j]
                }
                data.push(rowData)
            }
        }

        groupedData.value = data
    }

    reader.readAsText(file)
}

const setTableHeaders = (data) => {
    if (data.length > 0) {
        tableHeaders.value = Object.keys(data[0])
    }
}
</script>

<style scoped>
h1 {
    font-size: 40px;
    font-weight: bold;
}

#dlcsv {
    background: cyan;
    padding:10px 20px;
    border-radius: 10px;
    font-weight: bold;
}

#upcsv {
    background: rgba(108, 108, 108, 0.612);
    padding:10px 20px;
    border-radius: 10px;
    font-weight: bold;
}

.buttons {
    margin-bottom: 20px;
    display: flex;
    gap: 20px;
}

.tableCsv {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}
</style>
