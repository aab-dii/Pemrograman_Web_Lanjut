<template>
    <div class="product-table">
      <!-- Header untuk Nama Tabel dan Tombol -->
      <div class="table-header">
        <h2>Produk</h2>
        <div class="button-group">
          <button @click="addProduct" class="btn-action tambah">Tambah Produk</button>
          <button @click="filterProducts" class="filter-button">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 10H15M2.5 5H17.5M7.5 15H12.5" stroke="#5D6679" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>Filter
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
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProductTable',
    data() {
      return {
        products: [
          { id: 1, name: 'Mie Goreng Sedap', category: 'Makanan', price: 'Rp. 4500', stock: '43 Pcs', status: 'Tersedia' },
          { id: 2, name: 'Beng-Beng', category: 'Makanan', price: 'Rp. 3500', stock: '0 Pcs', status: 'Habis' },
          // Produk lainnya
        ]
      }
    },
    methods: {
      addProduct() {
        console.log("Tambah produk baru");
        // Logika untuk menambah produk baru
      },
      filterProducts() {
        console.log("Filter produk");
        // Logika untuk memfilter produk
      },
      editProduct(product) {
        console.log("Edit product: ", product);
      },
      deleteProduct(product) {
        console.log("Delete product: ", product);
      }
    }
  }

  </script>
  
  <style scoped>
  .product-table {
    height: 680px;
    width: 1096px;
    background-color: white; /* Latar belakang putih untuk tabel */
    padding: 20px; /* Menambahkan padding di sekitar tabel */
  }
  
  .table-header {
    margin-left: 10px;
    display: flex; /* Menggunakan flexbox untuk menyusun elemen secara horizontal */
    justify-content: space-between; /* Menyusun elemen di antara header */
    align-items: center; /* Memusatkan elemen secara vertikal */
    margin-bottom: 15px; /* Jarak antara header dan tabel */
  }
  
  h2 {
    margin: 0; /* Menghilangkan margin default dari h2 */
  }

.tambah{
    background-color: #007bff;
  }
.ubah{
    background-color: #20D171;
}

.hapus{
    background-color: #FF0000;
}

.btn-action {
  border-radius: 15%;
  padding: 10px 20px;
  color: white;
  border: none;
  cursor: pointer;
}

  .button-group{
    display: flex;
  }
  
  .button-group button {
    margin-right: 10px; /* Jarak antara tombol */
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

  .btnedit, .btnhapus{
    font-size: 13px;
    width: 80px;
    height: 40px;
  }

  .btn-action {
  padding: 5px 10px;
  border-radius: 4px; /* Menambahkan border-radius 4px */
}
  
  .text-left {
    text-align: left; /* Mengatur agar teks pada kolom produk rata kiri */
  }
  
  .text-center {
    text-align: center; /* Mengatur agar teks pada kolom kategori, harga, stok, dan status rata tengah */
  }
  
  .text-right {
    text-align: right; /* Mengatur agar teks pada kolom aksi rata kanan */
  }
  
  tr {
    border-bottom: 1px solid #ddd; /* Menambahkan border hanya di bagian bawah */
  }
  
  button {
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
  