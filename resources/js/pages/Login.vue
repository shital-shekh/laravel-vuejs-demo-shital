<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 380px;">

      <h3 class="text-center mb-4">Login</h3>

      <form @submit.prevent="login">

        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            placeholder="Enter your email"

          />
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Enter your password"

          />
        </div>

        <button class="btn btn-primary w-100 mt-2">
          Login
        </button>

      </form>

      <p class="text-center mt-3">
        Don’t have an account?
        <router-link to="/register">Register</router-link>
      </p>

    </div>
  </div>
</template>

<script>
import { toastSuccess, toastError } from "../utils/toast";
import api from "../utils/axios";

export default {
  name: "App",

  data() {
    return {
      email: "",
      password: "",
    };
  },

  created() {
    if (localStorage.getItem("token")) {
      this.$router.push("/dashboard");
    }
  },

  methods: {
    async login() {
      try {
        const res = await api.post("/login", {
          email: this.email,
          password: this.password,
        });

        toastSuccess(res.data.message);

        // Save token
        localStorage.setItem("token", res.data.data.token);

        // Redirect
        this.$router.push("/dashboard");

      } catch (err) {

        toastError(err.response.data.message);
      }
    },
  },
};
</script>

<style>
body {
  background-color: #f8f9fa;
}
.card {
  border-radius: 12px;
}
</style>
