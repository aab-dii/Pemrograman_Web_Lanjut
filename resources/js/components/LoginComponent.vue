<template>
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
        <p class="register-link">
            Belum punya akun? <a href="#" @click.prevent="$emit('toggle-form')">Daftar di sini</a>
        </p>
    </form>
</template>

<script>
export default {
    name: 'LoginComponent',
    data() {
        return {
            email: '',
            password: '',
            loading: false
        };
    },
    // methods: {
    //     async handleLogin() {
        
    //     }
    // }
    methods: {
    async handleLogin() {
        this.loading = true;
        try {
            setTimeout(() => {
                this.loading = false;
                this.$router.push({ name: 'dashboard' }); // Ganti dengan nama rute 'dashboard'
            }, 1000);
        } catch (error) {
            this.loading = false;
            alert('Login gagal, coba lagi!');
        }
    }
}

};
</script>
