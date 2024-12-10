<template>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <img src="../assets/logo_toko_dewi_login.jpg" alt="Toko Dewi Logo" />
        <span>TOKO DEWI</span>
      </div>
      <nav>
        <router-link to="/admin/dashboard" class="nav-link" active-class="active">
          <i class="fas fa-home"></i> Dashboard
        </router-link>
        <router-link to="/admin/dashboard/products" class="nav-link" active-class="active">
          <i class="fas fa-box"></i> Inventaris
        </router-link>
        <router-link to="/admin/dashboard/transactions" class="nav-link" active-class="active">
          <i class="fas fa-history"></i> Transaksi
        </router-link>
        <router-link to="/admin/dashboard/addStock" class="nav-link" active-class="active">
          <i class="fas fa-plus-circle"></i> Tambah Stok
        </router-link>
        <router-link to="/admin/dashboard/HistoryTransaction" class="nav-link" active-class="active">
          <i class="fas fa-exchange-alt"></i>Riwayat Transaksi
        </router-link>
        <router-link to="/admin/dashboard/users" class="nav-link" active-class="active">
          <i class="fas fa-store"></i> Manage User
        </router-link>
      </nav>
      <div class="bottom-menu">
        <a @click="handleLogout" class="nav-link">
          <i class="fas fa-sign-out-alt"></i> Log Out
        </a>
      </div>
    </aside>
    <main class="content">
      <header>
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search product, supplier, order" />
        </div>
        <div class="user-menu">
          <Span class="user-name">{{ nama }}</Span>
        </div>
      </header>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>

export default {
  name: 'DashboardLayout',
  computed: {
    nama() {
      return localStorage.getItem("name") || "Nama tidak tersedia";
    },
  },
  methods: {
    getNama() {
      const nama = localStorage.getItem('name')
    },
    handleLogout() {
      // Clear local data (e.g., token or user information)
      localStorage.clear(); // or sessionStorage if you use session
      console.log("Local data cleared!");

      // Redirect to the login page or homepage
      this.$router.push({ name: 'LogPage' }); // or to the homepage route if necessary
      // Prevent back navigation (replace the history state so the user cannot go back)
      window.history.pushState(null, '', window.location.href);
      window.onpopstate = function () {
        window.history.go(1); // Forcing the browser to go forward, preventing backward navigation
      };
    }
  }
}
</script>


<style scoped>
.dashboard {
  display: flex;
  min-height: 100vh;
  width: 100%;
  background-color: #f5f6fa;
}

.sidebar {
  width: 250px;
  background-color: #ffffff;
  padding: 20px;
  display: flex;
  flex-direction: column;
  border-right: 1px solid #e0e0e0;
  position: fixed;
  height: 100vh;
}

.logo {
  display: flex;
  align-items: center;
  margin-bottom: 30px;
}

.logo img {
  width: 40px;
  margin-right: 10px;
}

.logo span {
  font-weight: 600;
  font-size: 1.2rem;
}

nav {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: #333;
  text-decoration: none;
  margin-bottom: 8px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.nav-link i {
  margin-right: 10px;
  width: 20px;
}

.nav-link:hover {
  background-color: #f8f9fa;
}

.nav-link.active {
  background-color: #e9ecef;
  color: #2196F3;
  font-weight: 600;
}

.content {
  flex: 1;
  padding: 20px;
  margin-left: 250px;
  width: calc(100% - 250px);
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  background-color: #ffffff;
  padding: 15px 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.search-bar {
  display: flex;
  align-items: center;
  background-color: #f5f6fa;
  padding: 10px 15px;
  border-radius: 8px;
  width: 300px;
}

.search-bar input {
  border: none;
  background: transparent;
  margin-left: 10px;
  width: 100%;
  outline: none;
}

.search-bar i {
  color: #666;
}

.user-menu {
  display: flex;
  align-items: center;
  gap: 20px;
}

.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.product-overview,
.chart,
.best-sellers,
.low-stock {
  background-color: #ffffff;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

th,
td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  font-weight: 600;
  color: #666;
}

.low-stock-item {
  display: flex;
  align-items: center;
  padding: 10px;
  border-bottom: 1px solid #eee;
  gap: 15px;
}

.low-stock-item img {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 8px;
}

.low-tag {
  background-color: #ff6b6b;
  color: white;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
}

.bottom-menu {
  margin-top: auto;
  border-top: 1px solid #eee;
  padding-top: 20px;
}

h2 {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

h2 a {
  font-size: 0.9rem;
  color: #2196F3;
  text-decoration: none;
}
</style>