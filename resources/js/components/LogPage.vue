<template>
  <div class="login-page">
    <div class="left-column">
      <div class="store-icon">
        <img src="../assets/logo_toko_dewi_login.jpg" alt="Store Icon" width="100" height="100" />
      </div>
      <p class="description">
        Selamat datang di <strong>Toko Dewi</strong>, destinasi pilihan untuk kebutuhan sehari-hari Anda. Kami
        menyediakan berbagai macam produk berkualitas yang dapat memenuhi setiap kebutuhan Anda, mulai dari fashion,
        elektronik, hingga kebutuhan rumah tangga.
      </p>
      <p class="additional-info">
        Temukan kenyamanan berbelanja online dengan mudah dan aman bersama kami. Jangan ragu untuk menjelajahi katalog
        produk kami, dan nikmati berbagai promo menarik yang selalu kami tawarkan.
      </p>
    </div>
    <div class="right-column">
      <div class="login-box">
        <h1>Login</h1>
        <div v-if="error" class="error-message">
          {{ error }}
        </div>
        <form @submit.prevent="handleLogin">
          <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="email" required />
          </div>
          <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="password" required />
          </div>
          <button type="submit" class="login-button" :disabled="loading">
            {{ loading ? 'Loading...' : 'Login' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      error: null
    };
  },
  methods: {
    // async handleLogin() {
    //   this.loading = true;
    //   try {
    //     setTimeout(() => {
    //       this.loading = false;
    //       this.$router.push({ name: 'dashboard' }); // Ganti dengan nama rute 'dashboard'
    //     }, 1000);
    //   } catch (error) {
    //     this.loading = false;
    //     this.error = 'Login gagal, coba lagi!';
    //   }
    // }
    async handleLogin() {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: this.email,
          password: this.password,
        });

        // Validasi sukses login
        if (response.data.success) {
          const token = response.data.token;
          const userRole = response.data.role;
          const userEmail = response.data.email;
          const id = response.data.id;
          const name = response.data.name;

          if (!token || !userRole) {
            throw new Error('Token atau role tidak ditemukan dalam respons.');
          }

          localStorage.setItem('token', token);
          localStorage.setItem('email', userEmail);
          localStorage.setItem('id', id);
          localStorage.setItem('name', name);

          console.log(`User logged in with role: ${userRole}`);
          if (userRole === 'admin') {
            this.$router.push({ path: '/admin/dashboard' });
            console.log('keadmin');
          } else if (userRole === 'karyawan') {
            this.$router.push({ path: '/karyawan/dashboard' });
            console.log('kekaryawan');
          } else {
            throw new Error('Role tidak valid. Tidak dapat mengarahkan ke dashboard.');
          }

        } else {
          this.error = response.data.message || 'Login gagal, coba lagi!';
        }
      } catch (err) {
        console.error('Login error:', err);
        this.error = err.response?.data?.message || 'Terjadi kesalahan. Coba lagi!';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.login-page {
  display: flex;
  min-height: 100vh;
  background-color: #f9f9f9;
  font-family: Arial, sans-serif;
}

.left-column {
  flex: 1;
  padding: 40px;
  background-color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
}

.store-icon {
  display: flex;
  justify-content: center;
  width: 100%;
  margin-bottom: 40px;
}

.description,
.additional-info {
  margin-bottom: 20px;
  font-size: 16px;
  color: #444;
  line-height: 1.8;
  text-align: left;
  max-width: 600px;
}

.right-column {
  flex: 1;
  background-color: #1a73e8;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.login-box {
  background: white;
  padding: 40px;
  border-radius: 12px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #1a73e8;
  margin-bottom: 30px;
  font-size: 32px;
  text-align: center;
  font-weight: bold;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  display: block;
  font-size: 14px;
  margin-bottom: 8px;
  color: #1a73e8;
  font-weight: 500;
}

.input-group input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ced4da;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.3s;
}

.input-group input:focus {
  border-color: #1a73e8;
  outline: none;
  box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.1);
}

.login-button {
  width: 100%;
  padding: 12px;
  background-color: #1a73e8;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 500;
  margin-top: 10px;
  transition: background-color 0.3s;
}

.login-button:hover {
  background-color: #1557b0;
}

.login-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.error-message {
  background-color: #fee;
  color: #e33;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 15px;
  text-align: center;
  font-size: 14px;
}

@media (max-width: 768px) {
  .login-page {
    flex-direction: column;
  }

  .left-column,
  .right-column {
    flex: none;
    width: 100%;
  }

  .left-column {
    padding: 20px;
  }

  .login-box {
    margin: 20px;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.login-box {
  animation: fadeIn 0.5s ease-out;
}
</style>