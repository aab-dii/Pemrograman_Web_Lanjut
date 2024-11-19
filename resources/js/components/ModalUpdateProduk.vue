<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Ubah Produk</h2>
          <button class="close-btn" @click="closeModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18M6 6L18 18" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="image">Gambar Produk</label>
            <div class="image-upload">
              <label for="image" class="upload-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4 15V21H20V15M12 9L6 15M12 9L18 15" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Upload Gambar</span>
              </label>
              <input
                type="file"
                id="image"
                @change="handleFileUpload"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg"
              />
              <img v-if="imagePreview" :src="imagePreview" class="image-preview" />
            </div>
          </div>
  
          <div class="form-group">
            <label for="productName">Nama Produk</label>
            <input
              type="text"
              id="productName"
              v-model="productName"
              placeholder="Masukkan nama produk"
            />
          </div>
  
          <div class="form-group">
            <label for="category">Kategori</label>
            <select id="category" v-model="category">
              <option value="">Pilih Kategori</option>
              <option value="Makanan">Makanan</option>
              <option value="Minuman">Minuman</option>
            </select>
          </div>
  
          <div class="form-group">
            <label for="price">Harga</label>
            <input
              type="number"
              id="price"
              v-model="price"
              placeholder="Masukkan harga produk"
            />
          </div>
  
          <!-- <div class="form-group">
            <label for="quantity">Stok</label>
            <input disabled
              type="number"
              id="quantity"
              v-model="stock"
              placeholder="Masukkan jumlah stok"
            />
          </div> -->
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="closeModal" :disabled="loading">Batal</button>
          <button class="update-btn" @click="updateProduct" :disabled="loading">{{ loading ? 'Memperbarui...' : 'Perbarui' }}</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ModalUpdateProduk',
    props: {
      isVisible: {
        type: Boolean,
        default: false
      },
      productToEdit: {
        type: Object,
        default: () => null
      }
    },
    data() {
      return {
        productName: '',
        category: '',
        price: '',
        stock: '',
        image: null,
        imagePreview: null,
        loading: false
      };
    },
    watch: {
      productToEdit: {
        immediate: true,
        handler(newProduct) {
          if (newProduct) {
            this.productName = newProduct.name || '';
            this.category = newProduct.category || '';
            this.price = newProduct.price || '';
            this.stock = newProduct.stock || '';
            this.imagePreview = newProduct.image || null;
          }
        }
      }
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.image = file;
          this.imagePreview = URL.createObjectURL(file);
        }
      },
      async updateProduct() {
        if (!this.productName || !this.category || !this.price || !this.stock) {
          alert('Mohon lengkapi semua data.');
          return;
        }
  
        const formData = new FormData();
        formData.append('name', this.productName);
        formData.append('category', this.category);
        formData.append('price', this.price);
        formData.append('stock', this.stock);
        if (this.image) {
          formData.append('image', this.image);
        }
        // Tambahkan _method: 'PUT' untuk Laravel
        formData.append('_method', 'PUT');
  
        try {
          this.loading = true;
            // Kirim permintaan POST dengan _method=PUT
            await axios.post(`http://localhost:8000/api/products/${this.productToEdit.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            });

            // Emit event untuk memberitahu komponen induk bahwa produk diperbarui
            this.$emit('product-updated');

            // Tutup modal
            this.closeModal();
        } catch (error) {
          console.error('Error updating product:', error);
          alert('Terjadi kesalahan saat memperbarui produk');
        } finally {
          this.loading = false;
        }
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
  
  .image-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
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
  .add-btn {
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
  
  .add-btn {
    background-color: #007BFF;
    color: white;
    border: none;
  }
  
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  </style>