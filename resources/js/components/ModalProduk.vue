<template>
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
  </style>