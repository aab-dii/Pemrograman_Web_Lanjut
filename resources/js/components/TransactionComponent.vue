<template>
  <div class="transaction-page">
    <div class="header">
      <h2>Transaksi</h2>
      <button class="tambah-btn">Tambah</button>
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
          <button class="action-btn add">+</button>
          <button class="action-btn subtract">-</button>
          <button class="action-btn delete">Hapus</button>
        </div>
      </div>
    </div>
    <div class="footer">
      <button class="proses-btn">Proses</button>
    </div>
  </div>
</template>

<script>
import image1 from '@/assets/image 2.png'
import image2 from '@/assets/image.png'
import image3 from '@/assets/image 7.png'
import image4 from '@/assets/image 8.png'

export default {
name: 'TransactionPage',
data() {
  return {
    products: [
      { 
        id: 1, name: 'Yogurt Cimory', price: 'Rp 13000', total: 5, image: image1 
      },
      { 
        id: 2, 
        name: 'Mie Goreng Aceh', 
        price: 'Rp 13000', 
        total: 5, 
        image: image2 
      },
      { 
        id: 3, 
        name: 'Chitato', 
        price: 'Rp 13000', 
        total: 5, 
        image: image3 
      },
      { 
        id: 4, 
        name: 'Nescafe', 
        price: 'Rp 13000', 
        total: 5, 
        image: image4 
      },
    ]
  };
}
}
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
  padding-bottom: 20px;
  border-bottom: 1px solid #e9ecef;
}

.product-image {
  width: 100px;
  height: 100px;
  object-fit: contain;
  margin-right: 20px;
}
.product-actions{
  width: 300px;
  margin-right: 50px
}
.product-actions button{
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
  margin: 0;
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
  display: flex;
  justify-content: center;
  margin-top: 20px;
  text-align: right;
}

.proses-btn {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
</style>