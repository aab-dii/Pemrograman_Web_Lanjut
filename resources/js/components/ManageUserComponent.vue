<template>
  <div class="user-table">
    <div class="table-header">
      <h2>User</h2>
      <div class="button-group">
        <button @click="openAddUserModal" class="btn-action tambah">Tambah User</button>
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
        <tr v-for="user in filteredUsers" :key="user.id">
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

    <div class="pagination">
      <button @click="goToPreviousPage" :disabled="currentPage === 1 || users.length === 0">Previous</button>
      <span>Halaman {{ currentPage }} dari {{ lastPage }}</span>
      <button @click="goToNextPage" :disabled="currentPage === lastPage || users.length === 0">Next</button>
    </div>

    <ModalUser :isVisible="isModalVisible" @close="closeModal" @user-added="handleUserAdded" />
    <ModalUpdateUser :isVisible="isModalUpdateVisible" :userToEdit="userToEdit" @close="closeModal"
      @user-updated="handleUserAdded" />
  </div>
</template>

<script>
import axios from 'axios';
import ModalUser from './TambahUserComponent.vue';
import ModalUpdateUser from './ModalUpdateUser.vue';

export default {
  name: 'User Table',
  components: {
    ModalUser,
    ModalUpdateUser,
  },
  data() {
    return {
      users: [],
      currentPage: 1,
      lastPage: 1,
      isModalVisible: false,
      isModalUpdateVisible: false,
      userToEdit: null,
      currentUserId: null,  // Store the ID of the logged-in user
    };
  },

  computed: {
    filteredUsers() {
      // Filter out the current user from the list
      return this.users.filter(user => user.id !== this.currentUserId);
    },
  },

  mounted() {
    this.currentUserId = localStorage.getItem('id');
    console.log('ID Pengguna yang login:', this.currentUserId);
    this.fetchUsers();
  },

  methods: {
    async fetchUsers() {
  try {
    const response = await axios.get(`http://localhost:8000/api/users?page=${this.currentPage}`);

    if (response.data.success) {
      console.log('Fetched Users:', response.data.data.data);

      // Filter langsung untuk melewatkan user yang memiliki ID sama seperti user yang sedang login
      const fetchedUsers = response.data.data.data.filter(user => user.id != this.currentUserId);

      this.users = fetchedUsers;
      this.lastPage = response.data.data.last_page;
      console.log('filtered Users:', fetchedUsers);
    }
  } catch (error) {
    console.error('Error fetching users:', error);
  }
  },

    openAddUserModal() {
      this.isModalVisible = true;
    },

    closeModal() {
      this.isModalVisible = false;
      this.isModalUpdateVisible = false;
    },

    handleUserAdded() {
      this.closeModal();
      this.fetchUsers();
    },

    editUser(user) {
      this.userToEdit = { ...user };
      this.isModalUpdateVisible = true;
    },

    async deleteUser(user) {
      if (confirm(`Apakah Anda yakin ingin menghapus user ${user.name}?`)) {
        try {
          await axios.delete(`http://localhost: 8000/api/users/${user.id}`);
          this.fetchUsers();
        } catch (error) {
          console.error('Terjadi kesalahan saat menghapus user.', error);
          alert('Terjadi kesalahan saat menghapus user.');
        }
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
    },
  },
};
</script>

<style scoped>
.user-table {
  height: 680px;
  width: 100%;
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

.tambah {
  background-color: #007bff;
}

.ubah {
  background-color: #20D171;
}

.hapus {
  background-color: #FF0000;
}

.btn-action {
  border-radius: 10px;
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

th,
td {
  padding: 10px;
  border: none;
}

.btnaksi {
  width: fit-content;
  display: flex;
  gap: 10px;
  margin-left: auto;
}

.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}

.text-left {
  text-align: left;
}

.text-center {
  text-align: center;
}

.text-right {
  text-align: right;
}

tr {
  border-bottom: 1px solid #ddd;
}

button {
  padding: 5px 10px;
  cursor: pointer;
}
</style>