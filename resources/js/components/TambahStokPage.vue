<template>
    <div class="product-table-component">
      <div class="product-table bg-white p-6 rounded-lg shadow-md">
        <!-- Header untuk Nama Tabel dan Tombol -->
        <div class="table-header flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-gray-800">Produk</h2>
          <div class="button-group flex space-x-4">
            <button @click="filterProducts" class="filter-button">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 10H15M2.5 5H17.5M7.5 15H12.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span>Filters</span>
            </button>
          </div>
        </div>
  
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.category }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.stock }}</td>
                <td>
                  <span class="status-pill" :class="getStatusClass(product.status)">
                    {{ product.status }}
                  </span>
                </td>
                <td>
                  <button @click="tambahProduct(product)" class="btn-action tambah">
                    Tambah
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <div class="pagination">
          <button class="btn-pagination">
            Sebelumnya
          </button>
          <span class="page-info">Page 1 of 10</span>
          <button class="btn-pagination">
            Selanjutnya
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProductTable',
    data() {
      return {
        products: [
          { id: 1, name: 'Mie Goreng Sedap', category: 'Makanan', price: 'Rp. 4500', stock: '43 Pcs', status: 'Tersedia' },
          { id: 2, name: 'Beng - Beng', category: 'Makanan', price: 'Rp. 3500', stock: '0 Pcs', status: 'Habis' },
          { id: 3, name: 'Rinso', category: 'Alat RT', price: 'Rp. 2000', stock: '36 Pcs', status: 'Tersedia' },
          { id: 4, name: 'Aqua', category: 'Minuman', price: 'Rp. 5000', stock: '0 Pcs', status: 'Habis' },
          { id: 5, name: 'Le Minerale', category: 'Minuman', price: 'Rp. 6000', stock: '5 Pcs', status: 'Tersedia' },
          { id: 6, name: 'Good Day', category: 'Minuman', price: 'Rp. 7000', stock: '10 Pcs', status: 'Tersedia' },
          { id: 7, name: 'Indomie Goreng Aceh', category: 'Makanan', price: 'Rp. 3500', stock: '0 Pcs', status: 'Habis' },
          { id: 8, name: 'Indomie Kuah Soto Banjar', category: 'Makanan', price: 'Rp. 3500', stock: '43 Pcs', status: 'Tersedia' },
          { id: 9, name: 'Yogurt Cimory', category: 'Minuman', price: 'Rp. 10000', stock: '5 Pcs', status: 'Sedikit' },
          { id: 10, name: 'Chitato', category: 'Minuman', price: 'Rp. 13000', stock: '5 Pcs', status: 'Sedikit' },
        ]
      }
    },
    methods: {
      addProduct() {
        console.log("Tambah produk baru");
      },
      filterProducts() {
        console.log("Filter produk");
      },
      tambahProduct(product) {
        console.log("Tambah product: ", product);
      },
      getStatusClass(status) {
        switch (status) {
          case 'Tersedia':
            return 'status-tersedia';
          case 'Habis':
            return 'status-habis';
          case 'Sedikit':
            return 'status-sedikit';
          default:
            return '';
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .product-table-component {
    width: 1096px;
    font-family: 'Inter', sans-serif;
  }
  
  .product-table {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
  }
  
  .table-header h2 {
    background-color: white;
    font-size: 1.5rem;
    font-weight: 600;
  }
  
  .button-group {
    display: flex;
    justify-content: end;
    gap: 1rem;
  }
  
  .btn-action {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: background-color 0.2s;
  }
  
  .btn-action.tambah {
    background-color: #2563EB;
    color: white;
  }
  
  .btn-action.tambah:hover {
    background-color: #1D4ED8;
  }
  
  .filter-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.375rem;
    color: #4B5563;
    font-weight: 500;
    transition: background-color 0.2s;
  }
  
  .filter-button:hover {
    background-color: #F3F4F6;
  }
  
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  
  thead {
    background-color: #FFFFFF;
  }
  
  th, td {
    padding: 0.75rem 1.5rem;
    text-align: left;
    border: none;
  }
  
  th {
    color: #6B7280;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  tr{
    border-bottom: 1px solid #ddd;
  }

  tbody tr {
    border-bottom: 1px solid #E5E7EB;
    transition: background-color 0.2s;
  }
  
  tbody tr:hover {
    background-color: #F9FAFB;
  }
  
  .status-pill {
    display: inline-flex;
    align-items: center;
    padding: 0.125rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
  }
  
  .status-tersedia {
    color: #10A760;
  }
  
  .status-habis {
    color: #DA3E33;
  }
  
  .status-sedikit {
    color: #E19133;
  }
  
  .pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }
  
  .btn-pagination {
    background-color: white;
    color: #4B5563;
    border: 1px solid #D1D5DB;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: background-color 0.2s;
  }
  
  .btn-pagination:hover {
    background-color: #F3F4F6;
  }
  
  .page-info {
    font-size: 0.875rem;
    color: #6B7280;
  }
  </style>