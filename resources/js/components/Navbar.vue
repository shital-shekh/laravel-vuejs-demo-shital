<template>
  <nav class="navbar navbar-dark bg-dark py-3">
    <div class="container d-flex justify-content-between align-items-center">

      <!-- Left: Logo -->
      <div class="navbar-brand">
        <router-link to="/dashboard" class="text-white text-decoration-none">
          Logo
        </router-link>
      </div>

      <!-- Center: Menu -->
      <ul class="nav">
        <li class="nav-item">
          <router-link class="nav-link text-white" to="/dashboard">Dashboard</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link text-white" to="/categories">Categories</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link text-white" to="/profile">Profile</router-link>
        </li>
      </ul>

      <!-- Right: Logout -->
      <button class="btn btn-outline-light btn-sm" @click="logout">
        Logout
      </button>

    </div>
  </nav>
</template>

<script>
import api from "../utils/axios";
import { toastSuccess } from "../utils/toast";

export default {
  name: "Navbar",

  methods: {
    async logout() {
      await api.post("/logout");
      localStorage.removeItem("token");
      toastSuccess("Logged out!");
      this.$router.push("/");
    }
  }
};
</script>

<style>
.nav-link {
  margin-left: 15px;
}
.nav-link:hover {
  color: #ffa;
}
</style>
