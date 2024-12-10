<template>
    <div class="transaction-table">
        <div class="table-header">
            <h2>Transaksi</h2>
        </div>
    
        <table>
            <thead>
                <tr>
                    <th class="text-left">ID Transaksi</th>
                    <th>Produk</th>
                    <th>Jenis Transaksi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Email Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="transaction in transactions" :key="transaction.id">
                    <td class="text-left">{{ transaction.id }}</td>
                    <td class="text-center">{{ transaction.product_name }}</td>
                    <td class="text-center">{{ transaction.transaction_type }}</td>
                    <td class="text-center">{{ transaction.quantity }}</td>
                    <td class="text-center">{{ transaction.date }}</td>
                    <td class="text-center">{{ transaction.user_email }}</td>
                </tr>
            </tbody>
        </table>
    
        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button @click="goToPreviousPage" :disabled="currentPage === 1">Previous</button>
            <span>Halaman {{ currentPage }} dari {{ lastPage }}</span>
            <button @click="goToNextPage" :disabled="currentPage === lastPage">Next</button>
        </div>

        <!-- Loading indicator -->
        <div v-if="isLoading">Memuat...</div>

        <!-- Error message -->
        <div v-if="error" class="error-message">{{ error }}</div>
    </div>
</template>

<script>
    import axios from 'axios';
    
    export default {
        name: 'TransactionHistory',
        data() {
            return {
                transactions: [],
                currentPage: 1,  // Menambahkan currentPage untuk pagination
                lastPage: 1,     // Menyimpan halaman terakhir dari API response
                isLoading: false, // Flag untuk menunjukkan status pemuatan
                error: null,      // Menyimpan pesan error jika ada
            };
        },
        mounted() {
            this.fetchTransactions();
        },
        methods: {
            async fetchTransactions() {
                this.isLoading = true;  // Menandakan data sedang dimuat
                this.error = null;      // Menghapus pesan error sebelumnya
                try {
                    const response = await axios.get(`http://localhost:8000/api/getTransactions?page=${this.currentPage}`);
                    console.log('Transactions API Response:', response.data);
                    if (response.data.success) {
                        this.transactions = response.data.data.data;
                        this.lastPage = response.data.data.last_page;
                    }
                } catch (error) {
                    this.error = 'Terjadi kesalahan saat memuat data transaksi.';
                    console.error('Error fetching transactions:', error);
                } finally {
                    this.isLoading = false;  // Menandakan pemuatan selesai
                    console.log('data', this.transactions.user_email);
                }
            },
            goToPreviousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.fetchTransactions();
                }
            },
            goToNextPage() {
                if (this.currentPage < this.lastPage) {
                    this.currentPage++;
                    this.fetchTransactions();
                }
            }
        }
    };
</script>

<style scoped>
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }
</style>


<style scoped>
.product-table {
height: 680px;
width: 100%;
background-color: white;
padding: 20px;
}

.table-header {
margin-left: 10px;
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 15px;
}

h2 {
margin: 0;
}

.tambah { background-color: #007bff; }
.ubah { background-color: #20D171; }
.hapus { background-color: #FF0000; }

.btn-action {
border-radius: 10px;
padding: 10px 20px;
color: white;
border: none;
cursor: pointer;
}

.button-group {
display: flex;
}

.button-group button {
margin-right: 10px;
}

table {
width: 100%;
border-collapse: collapse;
}

thead {
background-color: #ffffff;
}

th, td {
padding: 10px;
border: none;
}

.filter-button {
display: flex;
align-items: center;
gap: 5px;
}

.filter-button svg {
vertical-align: middle;
}

.btnaksi {
width: fit-content;
display: flex;
gap: 10px;
margin-left: auto;
}

.text-left { text-align: left; }
.text-center { text-align: center; }
.text-right { text-align: right; }

tr {
border-bottom: 1px solid #ddd;
}

.pagination-controls{
display: flex;
justify-content: space-between;
align-items: center;
margin-top: 10px;
}

button {
padding: 5px 10px;
cursor: pointer;
}
</style>