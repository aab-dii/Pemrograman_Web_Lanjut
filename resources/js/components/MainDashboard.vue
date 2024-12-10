<!-- <template>
  <div class="dashboard-overview">
    <section class="product-overview">
      <h2>Keseluruhan Produk</h2>
      <div class="stats">
        <div class="stat-item">
          <h3 class="kategori">Kategori</h3>
          <p>3</p>
        </div>
        <div class="stat-item">
          <h3 class="total">Total Produk</h3>
          <p>90</p>
        </div>
        <div class="stat-item">
          <h3 class="stok_sedikit">Stok Sedikit</h3>
          <p>12</p>
        </div>
        <div class="stat-item">
          <h3 class="stok_habis">Stok Habis</h3>
          <p>12</p>
        </div>
      </div>
    </section>
    
    <div class="bottom-sections">
      <section class="best-sellers">
        <h2>Produk Terlaris <router-link class="lihat_semua" to="/products">Lihat Semua</router-link></h2>
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
        <h2>Stok Yang Sedikit <router-link class="lihat_semua" to="/products">Lihat Semua</router-link></h2>
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
</template> -->

<template>
  <div class="dashboard-overview">
    <section class="product-overview">
      <h2>Keseluruhan Produk</h2>
      <div class="stats">
        <div class="stat-item">
          <h3 class="total">Total Produk</h3>
          <p>{{ totalProducts }}</p>
        </div>
        <div class="stat-item">
          <h3 class="stok_sedikit">Stok Sedikit</h3>
          <p>{{ lowStock.length }}</p>
        </div>
        <div class="stat-item">
          <h3 class="stok_habis">Stok Habis</h3>
          <p>{{ outOfStockProducts }}</p>
        </div>
      </div>
    </section>

    <div class="bottom-sections">
      <section class="best-sellers">
        <h2>Produk Terlaris <router-link class="lihat_semua" to="/products">Lihat Semua</router-link></h2>
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
              <td>{{ product.total_terjual }}</td>
              <td>{{ product.stock }}</td>
              <td>{{ product.price }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <section class="low-stock">
        <h2>Stok Yang Sedikit <router-link class="lihat_semua" to="/products">Lihat Semua</router-link></h2>
        <div v-for="product in lowStock" :key="product.id" class="low-stock-item">
          <img :src="`http://localhost:8000/storage/products/${product.image}`" :alt="product.name" />
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
import axios from 'axios';
import BarChart from './BarChart.vue';

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
      bestSellers: [],
      lowStock: [],
      totalPenjualan: 0,
      totalProducts: 0, // Menyimpan total produk
      outOfStockProducts: 0 // Menyimpan jumlah produk dengan stok 0
    };
  },
  mounted() {
    this.fetchLowStock();
    this.fetchBestSellers();
    this.fetchTotalPenjualan();
    this.fetchTotalProducts(); // Tambahkan panggilan untuk fetchTotalProducts
    this.fetchOutOfStockProducts(); // Tambahkan panggilan untuk fetchOutOfStockProducts
  },
  methods: {
    fetchLowStock() {
      axios.get('http://localhost:8000/api/low-stock')
        .then(response => {
          this.lowStock = response.data;
          console.log(response.data);
        })
        .catch(error => {
          console.error("There was an error fetching low stock data:", error);
        });
    },
    fetchBestSellers() {
      axios.get('http://localhost:8000/api/best-sellers')
        .then(response => {
          this.bestSellers = response.data;
          console.log(response.data);
        })
        .catch(error => {
          console.error("There was an error fetching best sellers data:", error);
        });
    },
    fetchTotalPenjualan() {
      axios.get('http://localhost:8000/api/total-penjualan')
        .then(response => {
          this.totalPenjualan = response.data[0].total_penjualan;
          console.log(response.data);
        })
        .catch(error => {
          console.error("There was an error fetching total penjualan data:", error);
        });
    },
    fetchTotalProducts() {
      axios.get('http://localhost:8000/api/total-products')
        .then(response => {
          this.totalProducts = response.data[0].total_products;
          console.log(response.data);
        })
        .catch(error => {
          console.error("There was an error fetching total products data:", error);
        });
    },
    fetchOutOfStockProducts() {
      axios.get('http://localhost:8000/api/out-of-stock-products')
        .then(response => {
          this.outOfStockProducts = response.data[0].out_of_stock_products;
          console.log(response.data);
        })
        .catch(error => {
          console.error("There was an error fetching out of stock products data:", error);
        });
    }
  }
}
</script>





<!-- <script>
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
</script> -->

<style scoped>
/* Salin style yang berkaitan dengan section-section di bawah ini */
.product-overview, .chart, .best-sellers, .low-stock {
  background-color: #ffffff;
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.chart BarChart{
 background-color: #1570EF;
}

.dashboard-overview h2{
  font-size: 1.30rem;
}

.stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 5px;
  margin-top: 20px;
}

.chart div{
  display: flex;
  justify-content: center;
}

.stat-item {
  border-right: 1px solid grey;
  padding: 10px;
  /* background-color: blue; */
  text-align: left;
}

.stat-item h3 {
  font-size: 1.rem;
  margin-bottom: 10px;
}

.kategori{
  color: #1570EF;
}

.total{
  color: #1570EF;
}

.stok_sedikit{
  color: #E19133;
}

.stok_habis{
  color: #F36960;
}

.stat-item p {
  font-size: 1rem;
  font-weight: 600;
  color: #333;
}

.best-sellers h2{
  display: flex;
  justify-content: space-between;
}

.low-stock h2{
  display: flex;
  justify-content: space-between ;
}

.low-stock-item {
  margin-top: 10px;
  align-items: center;
  display: flex;  
  justify-content: space-around;
}

.lihat_semua {
  color: #0F50AA;
text-decoration: none;
}

.bottom-sections {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 20px;
}

img{
  width: 90px;
  height: 90px;
}

table {
  margin-top: 20px;
border-collapse: collapse; /* Menghindari border ganda */
width: 100%; /* Opsional: membuat tabel selebar container */
}

th, td {
border-top: 1px solid grey;
padding: 20px 20px; /* Memberikan ruang di sekitar konten */
text-align: left; /* Menyesuaikan teks (opsional) */
}

tr:nth-child(even) td {
background-color: #f9f9f9; /* Warna latar alternatif untuk baris genap */
}

/* Tambahkan style lain yang diperlukan */
</style>