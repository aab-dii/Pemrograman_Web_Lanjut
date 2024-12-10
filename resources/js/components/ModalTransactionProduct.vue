<template>
    <div>
      <!-- Modal -->
      <div class="modal-overlay">
        <div class="modal-container">
          <h2 class="modal-title">Pilih Produk</h2>
          <div class="search-box">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Cari nama Produk"
              class="search-input"/>
          </div>
          <div class="product-list">
            <div v-for="(product, index) in products" :key="index" class="product-item">
              <div class="product-info">
                <img :src="product.image" alt="product" class="product-image" />
                <div class="product-detail">
                  <p class="product-name">{{ product.name }}</p>
                  <p class="product-stock">Stok Tersisa: {{ product.stock }} Pcs</p>
                </div>
              </div>
              <button class="add-button" @click="addProduct(product)">+</button>
            </div>
          </div>
          <div class="modal-footer">
            <button class="close-button" @click="closeModal">Selesai</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ModalTransactionProduct',
    props: {
      isVisible: {
        type: Boolean,
        default: false
      },
      transactionToEdit: {
        type: Object,
        default: () => null
      }
    },
    data() {
      return {
        searchQuery: "",
        products: [],
      };
    },
    computed: {
      filteredProducts() {
        if (!this.searchQuery) return this.products;
        return this.products.filter((product) =>
          product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      },
    },
    mounted() {
    this.fetchProducts();
    },
    methods: {
      async fetchProducts() {
        try {
          const response = await axios.get(`http://localhost:8000/api/productsTransactions`);
          console.log('API Response:', response.data); 
          if (response.data.success) {
            this.products = response.data.data;
          }
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      },
      addProduct(product) {
        if (product.stock <= 0) {
          alert(`Stok produk "${product.name}" tidak tersedia.`);
          return;
        }
        this.$emit('add-product', product);
        product.stock -= 1;
      },
      closeModal() {
        this.$emit('close');
      },
    },
  };
  </script>
  
  <style scoped>
  /* Modal Overlay */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  /* Modal Container */
  .modal-container {
    display: flex;
    flex-direction: column; /* Mengatur layout vertikal */
    box-sizing: border-box;
    background: white;
    width: 500px;
    height: 520px;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  /* Modal Title */
  .modal-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
  }
  
  /* Search Box */
  .search-box {
    margin-bottom: 20px;
  }
  
  .search-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  /* Product List */
  .product-list {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 20px;
  }

  .product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
  }
  
  .product-info {
    display: flex;
    align-items: center;
  }
  
  .product-image {
    width: 80px;
    height: 80px;
    margin-right: 10px;
  }
  
  .product-name {
    font-size: 14px;
    font-weight: 500;
  }
  
  .product-stock {
    font-size: 12px;
    color: #888;
  }
  
  /* Add Button */
  .add-button {
    background: #28a745;
    color: white;
    border: none;
    width: 100px;
    border-radius: 4px;
    padding: 8px 12px;
    cursor: pointer;
  }
  
  .add-button:hover {
    background: #218838;
  }
  
  /* Footer */
  .modal-footer {
  display: flex;
  justify-content: flex-end; /* Mengarahkan tombol ke kanan */
  align-items: center;
  padding: 10px 20px; /* Memberikan ruang di sekitar */
  margin-top: auto; /* Mendorong footer ke bawah */
}

.product-list {
  flex-grow: 1; 
  overflow-y: auto; 
  margin-bottom: 10px; 
}

  
  .close-button {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    cursor: pointer;
  }
  
  .close-button:hover {
    background: #0056b3;
  }
  </style>
  