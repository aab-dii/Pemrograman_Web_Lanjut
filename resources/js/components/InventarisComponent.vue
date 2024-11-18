<template>
  <div class="product-table">
    <div class="table-header">
      <h2>Produk</h2>
      <div class="button-group">
        <button @click="openAddProductModal" class="btn-action tambah">Tambah Produk</button>
        <button @click="filterProducts" class="filter-button">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 10H15M2.5 5H17.5M7.5 15H12.5" stroke="#5D6679" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Filter
        </button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th class="text-left">Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Status</th>
          <th class="text-right"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="text-left">{{ product.name }}</td>
          <td class="text-center">{{ product.category }}</td>
          <td class="text-center">{{ product.price }}</td>
          <td class="text-center">{{ product.stock }}</td>
          <td class="text-center">{{ product.status }}</td>
          <td class="text-right">
            <div class="btnaksi">
              <button @click="editProduct(product)" class="btn-action ubah">Ubah</button>
              <button @click="deleteProduct(product)" class="btn-action hapus">Hapus</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <ModalProduk 
      :isVisible="isModalVisible" 
      @close="closeModal"
      @product-added="handleProductAdded"
    />
  </div>
</template>

<script>
import ModalProduk from './ModalProduk.vue';

export default {
  name: 'ProductTable',
  components: {
    ModalProduk
  },
  data() {
    return {
      products: [
        { id: 1, name: 'Mie Goreng Sedap', category: 'Makanan', price: 'Rp. 4500', stock: '43 Pcs', status: 'Tersedia' },
        { id: 2, name: 'Beng-Beng', category: 'Makanan', price: 'Rp. 3500', stock: '0 Pcs', status: 'Habis' },
      ],
      isModalVisible: false
    };
  },
  methods: {
    openAddProductModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    handleProductAdded(newProduct) {
      const product = {
        id: newProduct.id,
        name: newProduct.name,
        category: newProduct.category,
        price: newProduct.price,
        stock: newProduct.stock,
        image: newProduct.image
      };
      this.products.push(product);
      this.closeModal();
    },
    filterProducts() {
      console.log("Filter produk");
    },
    editProduct(product) {
      console.log("Edit product:", product);
    },
    deleteProduct(product) {
      this.products = this.products.filter(p => p.id !== product.id);
    }
  }
};
</script>
 
 <style scoped>
 .product-table {
  height: 680px;
  width: 1096px;
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
  border-radius: 15%;
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
 
 button {
  padding: 5px 10px;
  cursor: pointer;
 }
 </style>