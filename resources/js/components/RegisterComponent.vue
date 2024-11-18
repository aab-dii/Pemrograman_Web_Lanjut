<template>
    <form @submit.prevent="handleRegister">
        <div class="input-group">
            <label for="fullName">Nama Lengkap</label>
            <input type="text" id="fullName" v-model="fullName" required />
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="email" required />
        </div>
        <div class="input-group">
            <label for="phone">Nomor Telepon</label>
            <input type="tel" id="phone" v-model="phone" required />
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="password" required />
        </div>
        <div class="input-group">
            <label for="confirmPassword">Konfirmasi Password</label>
            <input type="password" id="confirmPassword" v-model="confirmPassword" required />
        </div>
        <button type="submit" class="register-button">Daftar</button>
        <p class="login-link">
            Sudah punya akun? <a href="#" @click.prevent="$emit('toggle-form')">Login di sini</a>
        </p>
    </form>
</template>

<script>
export default {
    name: 'RegisterComponent',
    data() {
        return {
            fullName: '',
            email: '',
            phone: '',
            password: '',
            confirmPassword: ''
        };
    },
    methods: {
        async handleRegister() {
            // Logic untuk register
        }
    }
};
</script>

<style>
.right-column {
    flex: 1;
    background-color: #1a73e8;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .register-box {
    background: white;
    padding: 40px;
    border-radius: 12px;
    width: 80%;
    max-width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-out;
  }
  
  h1 {
    color: #1a73e8;
    margin-bottom: 20px;
    font-size: 32px;
    text-align: center;
  }
  
  .input-group {
    margin-bottom: 15px;
  }
  
  .input-group label {
    display: flex;
    font-size: 14px;
    margin-bottom: 5px;
    color: #1a73e8;
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
  }
  
  .register-button {
    width: 100%;
    padding: 12px;
    background-color: #1a73e8;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
    transition: background-color 0.3s;
  }
  
  .register-button:hover {
    background-color: #1557b0;
  }
  
  .login-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #666;
  }
  
  .login-link a {
    color: #1a73e8;
    text-decoration: none;
    font-weight: 500;
  }
  
  .login-link a:hover {
    text-decoration: underline;
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
</style>