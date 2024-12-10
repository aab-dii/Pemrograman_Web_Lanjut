<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Ubah User</h2>
          <button class="close-btn" @click="closeModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18M6 6L18 18" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" v-model="userName" placeholder="Masukkan nama pengguna" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="email" placeholder="Masukkan email pengguna" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="password" placeholder="Masukkan password pengguna" />
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="closeModal" :disabled="loading">Batal</button>
          <button class="update-btn" @click="updateUser" :disabled="loading">{{ loading ? 'Memperbarui...' : 'Perbarui' }}</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ModalUpdateUser',
    props: {
      isVisible: Boolean,
      userToEdit: {
        type: Object,
        default: () => null,
      },
    },
    data() {
      return {
        userName: '',
        email: '',
        password: '',
        loading: false,
      };
    },
    watch: {
      userToEdit: {
        immediate: true,
        handler(newUser) {
          if (newUser) {
            this.userName = newUser.name || '';
            this.email = newUser.email || '';
            this.password = '';
          }
        },
      },
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      async updateUser() {
        if (!this.userName || !this.email) {
          alert('Mohon lengkapi semua data.');
          return;
        }
  
        this.loading = true;
        try {
          const response = await axios.put(
            `http://localhost:8000/api/users/${this.userToEdit.id}`,
            { name: this.userName, email: this.email, password: this.password || '' },
          );
          alert('User berhasil diperbarui');
          this.$emit('user-updated');
          this.closeModal();
        } catch (error) {
          console.error('Error updating user:', error);
          alert('Terjadi kesalahan saat memperbarui user.');
        } finally {
          this.loading = false;
        }
      },
    },
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

.image-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-group input .inputimg {
    margin-top: 20px;
    width: 88px;
    background-color: #007BFF;
}

.image-upload input[type="file"] {
    width: 88px;
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.form-group input {
    width: 300px;
    height: 40px;
}

.img {
    display: flex;
    flex-direction: column;
}

.upload-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: #F4F5F7;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
}

#role {
    width: 300px;
    height: 40px;
}

.image-preview {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
}

.cancel-btn,
.update-btn {
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}

.cancel-btn {
    background-color: #F4F5F7;
    color: #5D6679;
    border: none;
}

.update-btn {
    background-color: #007BFF;
    color: white;
    border: none;
}


button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>