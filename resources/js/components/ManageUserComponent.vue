<template>
    <div class="user-table">
      <div class="table-header">
        <h2>User</h2>
        <div class="button-group">
          <button @click="openAddUserModal" class="btn-action tambah">Tambah User</button>
          <button @click="filterUsers" class="filter-button">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 10H15M2.5 5H17.5M7.5 15H12.5" stroke="#5D6679" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>Filter
          </button>
        </div>
      </div>
  
      <table>
        <thead>
          <tr>
            <th class="text-left">Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th class="text-right"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td class="text-left">{{ user.name }}</td>
            <td class="text-center">{{ user.email }}</td>
            <td class="text-center">{{ user.role }}</td>
            <td class="text-right">
              <div class="btnaksi">
                <button @click="editUser(user)" class="btn-action ubah">Ubah</button>
                <button @click="deleteUser(user)" class="btn-action hapus">Hapus</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
  
      <div class="pagination-controls">
        <button @click="goToPreviousPage" :disabled="currentPage === 1">Previous</button>
        <span>Halaman {{ currentPage }} dari {{ lastPage }}</span>
        <button @click="goToNextPage" :disabled="currentPage === lastPage">Next</button>
      </div>
  
      <ModalUser
        :isVisible="isModalVisible"
        @close="closeModal"
        @save="saveUser"
        @user-added="handleUserAdded"
      />
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import ModalUser from './TambahUserComponent.vue';
  
  export default {
    name: 'UserTable',
    components: {
      ModalUser
    },
    data() {
      return {
        users: [],
        currentPage: 1,
        lastPage: 1,
        isModalVisible: false,
        userToEdit: null
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      async fetchUsers() {
        try {
          const response = await axios.get(`http://localhost:8000/api/users?page=${this.currentPage}`);
          if (response.data.success) {
            this.users = response.data.data.data;
            this.lastPage = response.data.data.last_page;
          }
        } catch (error) {
          console.error('Error fetching users:', error);
        }
      },
      openAddUserModal() {
        this.userToEdit = null;
        this.isModalVisible = true;
      },
      closeModal() {
        this.isModalVisible = false;
      },
      handleUserAdded() {
        this.closeModal();
        this.fetchUsers();
      },
      async saveUser(user) {
        try {
          if (this.userToEdit) {
            // Update existing user
            await axios.put(`http://localhost:8000/api/users/${this.userToEdit.id}`, user);
          } else {
            // Add new user
            await axios.post('http://localhost:8000/api/users', user);
          }
          this.fetchUsers(); // Refresh the user list
          this.closeModal();
        } catch (error) {
          console.error('Error saving user:', error);
        }
      },
      filterUsers() {
        console.log("Filter user");
      },
      editUser(user) {
        this.userToEdit = { ...user }; // Make a copy of the user
        this.isModalVisible = true;
      },
      async deleteUser(user) {
        try {
          await axios.delete(`http://localhost:8000/api/users/${user.id}`);
          this.fetchUsers(); // Refresh the user list
        } catch (error) {
          console.error('Error deleting user:', error);
        }
      },
      goToPreviousPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
          this.fetchUsers();
        }
      },
      goToNextPage() {
        if (this.currentPage < this.lastPage) {
          this.currentPage++;
          this.fetchUsers();
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .user-table {
    height: 680px;
    width: 1096px;
    background-color: white;
    padding: 20px;
  }
  
  .table-header {
    margin-left: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  
  h2 {
    margin: 0;
  }
  
  .tambah { background-color: #007bff; }
  .ubah { background-color: #20D171; }
  .hapus { background-color: #FF0000; }
  
  .btn-action {
    border-radius: 15%;
    padding: 10px 20px;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  .button-group {
    display: flex;
  }
  
  .button-group button {
    margin-right: 10px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  thead {
    background-color: #ffffff;
  }
  
  th, td {
    padding: 10px;
    border: none;
  }
  
  .filter-button {
    display: flex;
    align-items: center;
    gap: 5px;
  }
  
  .filter-button svg {
    vertical-align: middle;
  }
  
  .btnaksi {
    width: fit-content;
    display: flex;
    gap: 10px;
    margin-left: auto;
  }
  
  .text-left { text-align: left; }
  .text-center { text-align: center; }
  .text-right { text-align: right; }
  
  tr {
    border-bottom: 1px solid #ddd;
  }
  
  button {
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
  