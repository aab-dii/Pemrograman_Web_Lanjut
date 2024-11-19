<!-- <template>
    <div class="add-product">
      <h2>Tambah Produk</h2>
      <div class="image-upload">
        <div class="image-placeholder" @click="triggerFileUpload">
          <p v-if="!imagePreview">Tarik gambar<br>atau<br>Cari Gambar</p>
          <img v-else :src="imagePreview" alt="Product Preview" />
        </div>
        <input 
          type="file" 
          ref="fileInput" 
          @change="handleImageUpload" 
          style="display: none;"
          accept="image/*"
        >
      </div>
      <div class="form-group">
        <label for="productName">Nama Produk</label>
        <input 
          type="text" 
          id="productName" 
          v-model="productName" 
          placeholder="Masukkan nama produk"
        >
      </div>
      <div class="form-group">
        <label for="category">Kategori</label>
        <input 
          type="text" 
          id="category" 
          v-model="category" 
          placeholder="Pilih kategori produk"
        >
      </div>
      <div class="form-group">
        <label for="price">Harga</label>
        <input 
          type="text" 
          id="price" 
          v-model="price" 
          placeholder="Masukkan harga produk"
        >
      </div>
      <div class="form-group">
        <label for="quantity">Jumlah</label>
        <input 
          type="number" 
          id="quantity" 
          v-model="quantity" 
          placeholder="Masukkan jumlah produk"
        >
      </div>
      <div class="action-buttons">
        <button class="cancel-btn" @click="cancel">Batal</button>
        <button class="add-btn" @click="addProduct">Tambah</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AddProduct',
    data() {
      return {
        imagePreview: null,
        productName: '',
        category: '',
        price: '',
        quantity: ''
      };
    },
    methods: {
      triggerFileUpload() {
        this.$refs.fileInput.click();
      },
      handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.imagePreview = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      },
      cancel() {
        // Reset form or navigate away
        this.resetForm();
      },
      addProduct() {
        // Implement product addition logic here
        console.log('Adding product:', {
          name: this.productName,
          category: this.category,
          price: this.price,
          quantity: this.quantity,
          image: this.imagePreview
        });
        // After adding, you might want to reset the form or navigate away
        this.resetForm();
      },
      resetForm() {
        this.imagePreview = null;
        this.productName = '';
        this.category = '';
        this.price = '';
        this.quantity = '';
      }
    }
  };
  </script>
  
  <style scoped>


  .add-product {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
  }
  
  h2 {
    margin-bottom: 20px;
  }
  
  .image-upload {
    margin-bottom: 20px;
  }
  
  .image-placeholder {
    width: 150px;
    height: 150px;
    border: 2px dashed #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin: 0 auto;
  }
  
  .image-placeholder p {
    text-align: center;
    color: #888;
  }
  
  .image-placeholder img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
  }
  
  input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
  }
  
  .cancel-btn, .add-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .cancel-btn {
    background-color: #f0f0f0;
    color: #333;
  }
  
  .add-btn {
    background-color: #007bff;
    color: white;
  }
  </style> -->





















  <template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Tambah Produk</h2>
          <button class="close-btn" @click="closeModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18M6 6L18 18" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="image">Gambar Produk</label>
            <div class="image-upload">
              <label for="image" class="upload-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4 15V21H20V15M12 9L6 15M12 9L18 15" stroke="#5D6679" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
  
          <div class="form-group">
            <label for="quantity">Stok</label>
            <input 
              type="number" 
              id="quantity" 
              v-model="stock" 
              placeholder="Masukkan jumlah stok" 
            />
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="closeModal" :disabled="loading">
            Batal
          </button>
          <button class="add-btn" @click="addProduct" :disabled="loading">
            {{ loading ? 'Menambahkan...' : 'Tambah' }}
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ModalProduk',
    props: {
      isVisible: {
        type: Boolean,
        default: false
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
        loading: false,
        error: null
      };
    },
    methods: {
      handleFileUpload(event) {
        const file = event.target.files[0];
        this.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      closeModal() {
        this.$emit('close');
      },
      async addProduct() {
        // Validasi input
        if (!this.productName || !this.category || !this.price || !this.stock || !this.image) {
          alert('Harap isi semua field termasuk gambar');
          return;
        }
  
        // Set loading state
        this.loading = true;
        this.error = null;
  
        try {
          // Buat FormData untuk upload file
          const formData = new FormData();
          formData.append('name', this.productName);
          formData.append('category', this.category);
          formData.append('price', parseInt(this.price));
          formData.append('stock', parseInt(this.stock));
          formData.append('image', this.image);
  
          // Kirim data ke backend
          const response = await axios.post('/api/products', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
  
          // Emit event ke parent component dengan data produk yang baru dibuat
          this.$emit('product-added', response.data.data);
  
          // Reset form
          this.resetForm();
  
          // Tampilkan pesan sukses (opsional)
          alert('Produk berhasil ditambahkan');
  
        } catch (error) {
          // Tangani error
          console.error('Error adding product:', error);
          
          // Tampilkan pesan error
          if (error.response) {
            // Error dari server
            const errorMessages = error.response.data;
            const errorMessage = typeof errorMessages === 'object' 
              ? Object.values(errorMessages)
                  .flat()
                  .join('\n')
              : 'Gagal menambahkan produk';
            
            alert(errorMessage);
          } else if (error.request) {
            // Error jaringan
            alert('Tidak dapat terhubung ke server');
          } else {
            // Error lainnya
            alert('Terjadi kesalahan');
          }
        } finally {
          // Matikan loading state
          this.loading = false;
        }
      },
      resetForm() {
        this.productName = '';
        this.category = '';
        this.price = '';
        this.stock = '';
        this.image = null;
        this.imagePreview = null;
        this.$el.querySelector('#image').value = '';
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