<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 400px;">

      <h3 class="text-center mb-4">Create Account</h3>

      <form @submit.prevent="registerUser">

        <!-- Name -->
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            placeholder="Enter your full name"
            required
          >
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            placeholder="Enter your email"
            required
          >
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Create a password"
            required
          >
        </div>

        <button class="btn btn-success w-100 mt-2">
          Register
        </button>
      </form>

      <p class="text-center mt-3">
        Already have an account?
        <router-link to="/">Login</router-link>
      </p>

    </div>
  </div>
</template>

<script>

import { toastSuccess, toastError } from "../utils/toast";
import api from "../utils/axios";

export default {
  name: "Register",

  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },

  methods: {
    async registerUser() {
      try {
        await api.post("/register", {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        toastSuccess("Registration successful! Please login.");
        this.$router.push("/");

      } catch (err) {
        toastError(err.response.data.message);
      }
    }
  }
};
</script>

<style>
.card {
  border-radius: 12px;
}
</style>
