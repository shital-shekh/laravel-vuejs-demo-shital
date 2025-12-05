<template>
  <div>
    <Navbar />

    <div class="container mt-4" style="max-width: 600px">

      <h3>Update Profile</h3>

      <div class="card shadow p-4 mt-3">

        <!-- Name -->
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            placeholder="Enter your full name"
          />
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            placeholder="Enter your email"
          />
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label class="form-label">New Password (optional)</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Enter new password"
          />
        </div>

        <!-- Gender -->
        <div class="mb-3">
          <label class="form-label">Gender</label>
          <div>
            <label class="me-3">
              <input type="radio" value="male" v-model="gender" checked /> Male
            </label>
            <label class="me-3">
              <input type="radio" value="female" v-model="gender" /> Female
            </label>
            <label>
              <input type="radio" value="other" v-model="gender" /> Other
            </label>
          </div>
        </div>

        <!-- Country -->
        <div class="mb-3">
          <label class="form-label">Country</label>
          <select v-model="country" class="form-select">
            <option value="">Select Country</option>
            <option value="India">India</option>
            <option value="USA">USA</option>
            <option value="UK">United Kingdom</option>
            <option value="Canada">Canada</option>
            <option value="Australia">Australia</option>
          </select>
        </div>

        <!-- Hobbies -->
        <div class="mb-3">
          <label class="form-label">Hobbies</label>

          <div class="row">
            <div class="col-md-6" v-for="item in hobbyList" :key="item">
              <label>
                <input type="checkbox" :value="item" v-model="hobbies" />
                {{ item }}
              </label>
            </div>
          </div>
        </div>

        <!-- Profile Picture -->
        <div class="mb-3">
          <label class="form-label">Profile Picture</label>
          <input type="file" class="form-control" @change="onImageChange" />

          <!-- Preview Image -->
          <div v-if="preview" class="mt-3">
            <img :src="preview" class="rounded" width="120" height="120" />
          </div>
        </div>


        <button class="btn btn-primary" @click="updateProfile">
          Update
        </button>

      </div>

    </div>
  </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import api from "../utils/axios";
import { toastSuccess, toastError } from "../utils/toast";

export default {
  components: { Navbar },

  data() {
    return {
      name: "",
      email: "",
      password: "",
      gender: "",
      country: "",
      hobbies: [],
      hobbyList: ["Music", "Travel", "Sports", "Reading", "Coding", "Gaming"],
      image: null,
      preview: null,
    };
  },

  async created() {
    try {
      const res = await api.get("/user");
      this.name = res.data.data.name;
      this.email = res.data.data.email;
      this.gender = res.data.data.gender ?? "";
      this.country = res.data.data.country ?? "";
      this.hobbies = res.data.data.hobbies ? JSON.parse(res.data.data.hobbies) : [];
      this.preview = res.data.data.image_url ?? null;
    } catch (err) {
      toastError("Failed to load profile!");
      this.$router.push("/");
    }
  },

  methods: {
    onImageChange(event) {
      const file = event.target.files[0];
      this.image = file;
      this.preview = URL.createObjectURL(file);
    },

    async updateProfile() {
      try {
        const payload = {
          name: this.name,
          email: this.email,
          password: this.password,
          gender: this.gender,
          country: this.country,
          hobbies: this.hobbies,
          avatar: this.image,
        };

        // only send password if user entered
        if (this.password !== "") {
          payload.password = this.password;
        }

        await api.post("/profile/update", payload);

        toastSuccess("Profile updated successfully!");

      } catch (err) {
        toastError("Update failed!");
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
