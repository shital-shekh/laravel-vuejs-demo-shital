<template>
  <div>
    <Navbar />

    <div class="container mt-4">
      <div class="d-flex justify-content-between mb-3">
        <h3>Categories</h3>

        <router-link to="/categories/create" class="btn btn-primary">
          Add Category
        </router-link>
      </div>

      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th width="80">ID</th>
            <th>Name</th>
            <th width="150">Action</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="cat in categories" :key="cat.id">
            <td>{{ cat.id }}</td>
            <td>{{ cat.name }}</td>
            <td>
              <router-link
                :to="'/categories/' + cat.id + '/edit'"
                class="btn btn-warning btn-sm"
              >
                Edit
              </router-link>
              &nbsp;
              <button
                @click="deleteCategory(cat.id)"
                class="btn btn-danger btn-sm"
              >
                Delete
              </button>
            </td>
          </tr>

          <tr v-if="categories.length === 0">
            <td colspan="3" class="text-center">No categories found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Navbar from "../../components/Navbar.vue";
import api from "../../utils/axios";
import Swal from "sweetalert2";
import { toastSuccess, toastError } from "../../utils/toast";

export default {
  components: { Navbar },

  data() {
    return {
      categories: [],
    };
  },

 async created() {
    await this.loadCategories();
  },

  methods: {
    async loadCategories() {
      try {
        const res = await api.get("/categories");
        this.categories = res.data.data;
      } catch (error) {
        toastError(error.response.data.message);
      }
    },
    deleteCategory(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                api.delete(`/categories/${id}`)
                    .then((response) => {
                        toastSuccess("Category deleted successfully!");
                        this.loadCategories(); 
                    })
                    .catch((error) => {
                        toastError(error.response.data.message);
                    });
            }
        });
    },
  },
};
</script>
