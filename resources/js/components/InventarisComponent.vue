<template>
  <div class="product-table">
    <div class="table-header">
      <h2>Produk</h2>
      <div class="button-group">
        <button @click="openAddProductModal" class="btn-action tambah">Tambah Produk</button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th class="text-left">Produk</th>
          <th>Gambar</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th class="text-right"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="text-left"><img :src="product.image" alt="Product Image" width="50"/></td>
          <td class="text-center">{{ product.name }}</td>
          <td class="text-center">{{ product.category }}</td>
          <td class="text-center">{{ product.price }}</td>
          <td class="text-center">{{ product.stock }}</td>
          <td class="text-right">
            <div class="btnaksi">
              <button @click="editProduct(product)" class="btn-action ubah">Ubah</button>
              <button @click="deleteProduct(product)" class="btn-action hapus">Hapus</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination-controls">
      <button @click="goToPreviousPage" :disabled="currentPage === 1">Previous</button>
      <span>Halaman {{ currentPage }} dari {{ lastPage }}</span>
      <button @click="goToNextPage" :disabled="currentPage === lastPage">Next</button>
    </div>

    <ModalProduk
      :isVisible="isModalVisible"
      @close="closeModal"
      @save="saveProduct"
      @product-added="handleProductAdded"
    />

    <ModalUpdateProduk
      :isVisible="isModalUpdateVisible"
      :productToEdit="productToEdit"
      @close="closeModal"
      @product-updated="handleProductUpdated"
    />
  </div>
</template>

<script>
import axios from 'axios';
import ModalProduk from './ModalProduk.vue';
import ModalUpdateProduk from './ModalUpdateProduk.vue';

export default {
  name: 'InventarisComponent',
  components: {
    ModalProduk,
    ModalUpdateProduk
  },
  data() {
    return {
      products: [],
      currentPage: 1,
      lastPage: 1,
      isModalVisible: false,
      isModalUpdateVisible: false,
      productToEdit: null
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get(`http://localhost:8000/api/products?page=${this.currentPage}`);
        if (response.data.success) {
          this.products = response.data.data.data;
          this.lastPage = response.data.data.last_page;
        }
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    openAddProductModal() {
      this.productToEdit = null;
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.isModalUpdateVisible = false;
      this.productToEdit = null;
    },
    handleProductAdded() {
      this.closeModal();
      this.fetchProducts();
    },
    editProduct(product) {
      this.productToEdit = { ...product };
      this.isModalUpdateVisible = true;
    },
    handleProductUpdated() {
      this.closeModal();
      this.fetchProducts();
    },
    async deleteProduct(product) {
      if (confirm(`Apakah Anda yakin ingin menghapus produk: ${product.name}?`)) {
        try {
          await axios.delete(`http://localhost:8000/api/products/${product.id}`);
          this.fetchProducts();
        } catch (error) {
          console.error('Error deleting product:', error);
        }
      }
    },
    goToPreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchProducts();
      }
    },
    goToNextPage() {
      if (this.currentPage < this.lastPage) {
        this.currentPage++;
        this.fetchProducts();
      }
    }
  }
};
</script>

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