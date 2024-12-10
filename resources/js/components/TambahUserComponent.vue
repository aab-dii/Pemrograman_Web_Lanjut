<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Tambah Pengguna</h2>
          <button class="close-btn" @click="closeModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18M6 6L18 18" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama</label>
            <input 
              type="text" 
              id="name" 
              v-model="name" 
              placeholder="Masukkan nama pengguna" 
            />
          </div>
  
          <div class="form-group">
            <label for="email">Email</label>
            <input 
              type="email" 
              id="email" 
              v-model="email" 
              placeholder="Masukkan email pengguna" 
            />
          </div>
  
          <div class="form-group">
            <label for="password">Password</label>
            <input 
              type="password" 
              id="password" 
              v-model="password" 
              placeholder="Masukkan password pengguna" 
            />
          </div>
  
          <div class="form-group role">
            <label for="role">Role</label>
            <select id="role" v-model="role">
              <option value="">Pilih Role</option>
              <option value="Admin">Admin</option>
              <option value="Karyawan">Karyawan</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="closeModal" :disabled="loading">
            Batal
          </button>
          <button class="add-btn" @click="addUser" :disabled="loading">
            {{ loading ? 'Menambahkan...' : 'Tambah' }}
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ModalPengguna',
    props: {
      isVisible: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        name: '',
        email: '',
        password: '',
        role: '',
        loading: false,
        error: null
      };
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      async addUser() {
        if (!this.name || !this.email || !this.password || !this.role) {
          alert('Harap isi semua field');
          return;
        }
  
        this.loading = true;
        this.error = null;
  
        try {
          const response = await axios.post('/api/users', {
            name: this.name,
            email: this.email,
            password: this.password,
            role: this.role
          });
  
          // Emit event ke parent component dengan data pengguna yang baru dibuat
          this.$emit('user-added', response.data.data);
  
          // Reset form
          this.resetForm();
  
          // Tampilkan pesan sukses (opsional)
          alert('Pengguna berhasil ditambahkan');
        } catch (error) {
          // Tangani error
          console.error('Error adding user:', error);
          alert('Terjadi kesalahan saat menambahkan pengguna');
        } finally {
          // Matikan loading state
          this.loading = false;
        }
      },
      resetForm() {
        this.name = '';
        this.email = '';
        this.password = '';
        this.role = '';
      }
    }
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  
  .modal-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    width: 600px;
    padding: 20px;
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .close-btn {
    background-color: transparent;
    border: none;
    cursor: pointer;
  }

  .form-group input{
    width: 300px;
    height: 40px;
  }
  
  .form-group select{
    width: 300px;
    height: 40px;
  }

  .form-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  
  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
  }
  
  .cancel-btn,
  .add-btn {
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
  }
  
  .cancel-btn {
    background-color: #f4f5f7;
    color: #5d6679;
    border: none;
  }
  
  .add-btn {
    background-color: #007bff;
    color: white;
    border: none;
  }
  
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  </style>