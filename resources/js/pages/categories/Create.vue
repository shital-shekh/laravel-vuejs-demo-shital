<template>
    <div>
        <Navbar />

        <div class="container mt-4" style="max-width: 500px;">
            <h3>Add Category</h3>

            <div class="card p-4 shadow mt-3">
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input
                        v-model="name"
                        type="text"
                        class="form-control"
                        placeholder="Enter category name"
                    />
                </div>

                <button class="btn btn-success" @click="saveCategory">
                    Save
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../../components/Navbar.vue";
import api from "../../utils/axios";
import { toastSuccess, toastError } from "../../utils/toast";

export default {
    components: {
        Navbar
    },
    data() {
        return {
            name: "",
        };
    },
    methods: {
    async saveCategory() {
      try {
        await api.post("/categories", { name: this.name });

        toastSuccess("Category added successfully!");
        this.$router.push("/categories");

      } catch (err) {
        toastError(err.response.data.message);
      }
    }
  }
}

</script>
