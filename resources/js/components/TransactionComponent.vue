<template>
  <div class="transaction-page">
    <div class="header">
      <h2>Transaksi</h2>
      <button @click="openModal" class="tambah-btn">Tambah</button>
    </div>
    <div class="product-list">
      <div v-for="product in products" :key="product.id" class="product-item">
        <img :src="product.image" :alt="product.name" class="product-image">
        <div class="product-info">
          <h3>{{ product.name }}</h3>
          <p>Harga: {{ product.price }}</p>
          <p>Total: {{ product.total }}</p>
        </div>
        <div class="product-actions">
          <button class="action-btn add" @click="tambahStok(product)">+</button>
          <button class="action-btn subtract" @click="kurangStok(product)">-</button>
          <button class="action-btn delete" @click="hapusProduk(product)">Hapus</button>
        </div>
      </div>
    </div>
    <div class="footer">
      <p>Total Biaya: Rp {{ totalHarga }}</p>
      <button @click="prosesTransaksi()" class="proses-btn">Proses</button>
    </div>

    <ModalTransactionProduct v-if="isModalVisible" :isVisible="isModalVisible" @close="closeModal"
      @add-product="addProductToTransaction" />
  </div>
</template>

<script>
import axios from 'axios';
import ModalTransactionProduct from './ModalTransactionProduct.vue';

export default {
  name: 'TransactionPage',
  components: {
    ModalTransactionProduct,
  },
  data() {
    return {
      isModalVisible: false,
      transactionToEdit: null,
      products: [], // Daftar produk dalam transaksi
    };
  },

  computed: {
    totalHarga() {
      return this.products.reduce((total, product) => {
        return total + (product.price * product.total);
      }, 0);
    }
  },

  methods: {
    getUserId() {
      const userId = localStorage.getItem('id');
    },
    addProductToTransaction(product) {
      const existingProduct = this.products.find(p => p.id === product.id);
      if (existingProduct) {
        existingProduct.total += 1;
      } else {
        this.products.push({
          ...product,
          total: 1
        });
      }
      console.log('Produk ditambahkan ke transaksi:', product);
    },

    // Menambah stok produk (+ button)
    tambahStok(product) {
      const existingProduct = this.products.find(p => p.id === product.id);
      if (existingProduct) {
        if (existingProduct.total < product.stock) {
          existingProduct.total += 1;
        } else {
          alert(`Stok produk ${product.name} sudah mencapai batas ${product.stock}`);
        }
      } else {
        this.products.push({
          ...product,
          total: 1
        });
        console.log('Produk ditambahkan ke transaksi:', product.name);
      }
    },

    // Mengurangi stok produk (- button)
    kurangStok(product) {
      const existingProduct = this.products.find(p => p.id === product.id);
      if (existingProduct && existingProduct.total > 1) {
        existingProduct.total -= 1;
      }
    },

    // Menghapus produk dari daftar transaksi
    hapusProduk(product) {
      this.products = this.products.filter(p => p.id !== product.id);
      console.log(`Produk ${product.name} dihapus dari daftar transaksi.`);
    },

    openModal() {
      this.isModalVisible = true;
    },

    closeModal() {
      this.isModalVisible = false;
    },

    formatDate(date) {
      const d = new Date(date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const day = String(d.getDate()).padStart(2, '0');
      const hours = String(d.getHours()).padStart(2, '0');
      const minutes = String(d.getMinutes()).padStart(2, '0');
      const seconds = String(d.getSeconds()).padStart(2, '0');

      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    },

    // Proses transaksi dan kirim data ke Laravel API
    async prosesTransaksi() {
      try {
        for (const product of this.products) {
          // Validasi stok sebelum mengirim transaksi
          if (product.total > product.stock) {
            alert(`Stok untuk produk ${product.name} tidak mencukupi.`);
            continue; // Lewati produk ini
          }

          const transaksiData = {
            transaction_type: 'penjualan',
            date: this.formatDate(new Date()),
            user_id: localStorage.getItem('id'),
            product_id: product.id,
            quantity: product.total,
          };

          console.log('Mengirim data transaksi:', transaksiData);

          try {
            // Kirim transaksi ke API Laravel
            await axios.post('http://localhost:8000/api/transactions', transaksiData);
            console.log(`Transaksi produk ${product.name} berhasil diproses.`);

            // Update stok produk melalui API Laravel
            const updatedStock = product.stock - product.total;

            await axios.put(`http://localhost:8000/api/products/${product.id}`, {
              name: product.name,
              category: product.category,
              price: product.price,
              stock: updatedStock, // Stok yang diperbarui
            });

            console.log(`Stok produk ${product.name} berhasil diperbarui ke ${updatedStock}.`);

            // Perbarui stok di sisi lokal (frontend)
            product.stock = updatedStock;
          } catch (error) {
            console.error(`Proses transaksi atau update stok untuk produk ${product.name} gagal:`, error.message);
            alert(`Transaksi produk ${product.name} gagal.`);
          }
        }

        // Tampilkan pesan jika semua transaksi selesai
        alert('Semua transaksi berhasil diproses.');
        this.products = [];
      } catch (error) {
        console.error('Terjadi kesalahan saat memproses transaksi:', error);
        alert('Proses transaksi gagal secara keseluruhan.');
      }
    },
  }
};
</script>

<style scoped>
.transaction-page {
  background-color: #ffffff;
  width: 100%;
  padding: 20px;
  border-radius: 8px;
  height: 645px;
  max-height: 645px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.tambah-btn {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

.product-list {
  border-radius: 8px;
  padding: 20px;
  height: 80%;
  max-height: 80%;
  overflow-y: auto;
  overflow-x: hidden;
}

.product-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  height: 130px;
  border-bottom: 1px solid #e9ecef;
}

.product-image {
  background-color: #dc3545;
  width: 200px;
  height: 100%;
  object-fit: fill;
  margin-right: 20px;
}

.product-actions {
  width: 300px;
  margin-right: 50px
}

.product-actions button {
  width: 86px;
  height: 40px;
}

.product-info {
  flex-grow: 1;
}

.product-info h3 {
  margin: 0 0 5px 0;
}

.product-info p {
  margin: 0 0 5px 0;
  color: #6c757d;
}

.product-actions {
  display: flex;
  gap: 10px;
}

.action-btn {
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.action-btn.add {
  background-color: #28a745;
  color: white;
}

.action-btn.subtract {
  background-color: #ffc107;
  color: black;
}

.action-btn.delete {
  background-color: #dc3545;
  color: white;
}

.footer {
  width: 100%;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 20px;
  text-align: right;
}

.proses-btn {
  background-color: #007bff;
  color: white;
  border: none;
  width: 300px;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
</style>