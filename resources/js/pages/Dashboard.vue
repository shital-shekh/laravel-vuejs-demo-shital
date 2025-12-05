<template>
  <div>

    <Navbar />

    <div class="container mt-4">
      <h3>Welcome, {{ userName }}</h3>
    </div>
  </div>
</template>

<script>
import { toastSuccess, toastError } from "../utils/toast";
import api from "../utils/axios";
import Navbar from "../components/Navbar.vue";

export default {
  name: "Dashboard",

  components: {
    Navbar
  },

  data() {
    return {
      userName: "",
    };
  },

  async created() {
    try {
      const res = await api.get("/user");
      this.userName = res.data.data.name;
    } catch (err) {
      toastError(err.response.data.message);
      this.$router.push("/");
    }
  },

  methods: {
    async logout() {
      try {
        await api.post("/logout");
        toastSuccess("Logged out successfully!");
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
