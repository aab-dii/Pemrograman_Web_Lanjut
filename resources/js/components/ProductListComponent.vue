<template>
  <div class="container-pop">

    <div class="product-selection">
      <h2>Pilih Produk</h2>
      <div class="search-bar">
      <input type="text" v-model="searchQuery" placeholder="Cari nama Produk">
    </div>
    <div class="product-list">
      <div v-for="(product, index) in filteredProducts" :key="index" class="product-item">
        <img :src="product.image" :alt="product.name" class="product-image" />
        <div class="product-details">
          <p class="product-name">{{ product.name }}</p>
          <p class="product-stock">Stok Tersisa: {{ product.stock }} Packet</p>
        </div>
        <button @click="addToCart(product)" class="add-button">+</button>
      </div>
    </div>
    <div class="btnfinish">
      <button class="finish-button">Selesai</button>
    </div>
  </div>
</div>
</template>

<script>
import image2 from '@/assets/image 2.png';
import image7 from '@/assets/image 7.png';

export default {
  name: 'ProductListComponent',
  data() {
    return {
      searchQuery: '',
      products: [
        { name: 'Yogurt Cimory', stock: 5, image: image2 },
        { name: 'Chitato', stock: 5, image: image7 },
        { name: 'Chitato', stock: 5, image: image7 },
        { name: 'Yogurt Cimory', stock: 5, image: image2 },
        { name: 'Chitato', stock: 5, image: image7 },
        { name: 'Chitato', stock: 5, image: image7 },
      ]
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter(product =>
        product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  }
};
</script>

<style scoped>

.container-pop{
  display: flex;
  justify-content: center;
  background-color: #ffffff;
  width: 500px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.product-selection {
  /* display: flex; */
  margin-top: 10px;
  padding: 16px;
  font-family: Arial, sans-serif;
}

h2 {
  margin-top: 0;
  margin-bottom: 16px;
}

.search-bar input {
  width: 370px;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.product-list {
  padding: 20px;
  width: 370px;
  max-height: 400px;
  overflow-y: auto;
}

.product-item {
  display: flex;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid #eee;
}

.product-image {
  width: 50px;
  height: 50px;
  object-fit: contain;
  margin-right: 16px;
}

.product-details {
  flex-grow: 1;
}

.product-name {
  font-weight: bold;
  margin: 0;
}

.product-stock {
  font-size: 0.9em;
  color: #666;
  margin: 0;
}

.add-button {
  width: 86px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 18px;
  cursor: pointer;
}

.btnfinish{
  width: 370px;
  display: flex;
}

.finish-button {
  /* display: flex; */
  /* flex: end; */
  width: 100px;
  margin-left: auto;
  background-color: #1976D2;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 12px;
  margin-top: 16px;
  font-size: 16px;
  cursor: pointer;
}
</style>