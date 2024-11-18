<template>
    <div class="dashboard-overview">
      <section class="product-overview">
        <h2>Keseluruhan Produk</h2>
        <div class="stats">
          <div class="stat-item">
            <h3>Kategori</h3>
            <p>3</p>
          </div>
          <div class="stat-item">
            <h3>Total Produk</h3>
            <p>90</p>
          </div>
          <div class="stat-item">
            <h3>Stok Sedikit</h3>
            <p>12</p>
          </div>
          <div class="stat-item">
            <h3>Stok Habis</h3>
            <p>12</p>
          </div>
        </div>
      </section>
      
      <section class="chart">
        <h2>Barang Masuk & Barang Terjual</h2>
        <BarChart :chartData="chartData" />
      </section>
      
      <div class="bottom-sections">
        <section class="best-sellers">
          <h2>Produk Terlaris <router-link to="/products">Lihat Semua</router-link></h2>
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jumlah Terjual</th>
                <th>Stok</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in bestSellers" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.sold }}</td>
                <td>{{ product.stock }}</td>
                <td>{{ product.price }}</td>
              </tr>
            </tbody>
          </table>
        </section>
        
        <section class="low-stock">
          <h2>Stok Yang Sedikit <router-link to="/products">Lihat Semua</router-link></h2>
          <div v-for="product in lowStock" :key="product.id" class="low-stock-item">
            <img :src="product.image" :alt="product.name" />
            <div>
              <h3>{{ product.name }}</h3>
              <p>Stok Tersisa: {{ product.stock }} Packet</p>
            </div>
            <span class="low-tag">Low</span>
          </div>
        </section>
      </div>
    </div>
  </template>
  
  <script>
  import BarChart from './BarChart.vue';
  import lowStockImage1 from '@/assets/image 2.png';
  import lowStockImage2 from '@/assets/image 7.png';
  
  export default {
    name: 'DashboardOverview',
    components: {
      BarChart
    },
    data() {
      return {
        chartData: {
          // Data untuk grafik
        },
        bestSellers: [
          { id: 1, name: 'Indomie Goreng Aceh', sold: 30, stock: 0, price: 'Rp. 3500' },
          { id: 2, name: 'Yogurt Cimory', sold: 21, stock: 5, price: 'Rp. 10000' },
          { id: 3, name: 'Rinso', sold: 19, stock: 36, price: 'Rp. 2000' },
        ],
        lowStock: [
          { id: 1, name: 'Yogurt Cimory', stock: 5, image: lowStockImage1 },
          { id: 2, name: 'Chitato', stock: 5, image: lowStockImage2 },
          { id: 3, name: 'Chitato', stock: 5, image: lowStockImage2 },
        ]
      };
    }
  }
  </script>
  
  <style scoped>
  /* Salin style yang berkaitan dengan section-section di bawah ini */
  .product-overview, .chart, .best-sellers, .low-stock {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }
  
  .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 20px;
  }
  
  .stat-item {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    text-align: center;
  }
  
  .stat-item h3 {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
  }
  
  .stat-item p {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
  }
  
  .bottom-sections {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 20px;
  }
  
  /* Tambahkan style lain yang diperlukan */
  </style>