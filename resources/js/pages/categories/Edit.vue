<template>
    <div>
        <Navbar />

        <div class="container mt-4" style="max-width: 500px;">
            <h3>Edit Category</h3>

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

                <button class="btn btn-primary" @click="updateCategory">
                    Update
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
    async created() {
        try {
            const id = this.$route.params.id;
            const res = await api.get(`/categories/${id}`);

            this.name = res.data.data.name;

        } catch (err) {
            toastError("Failed to load category");
        }
    },
    methods: {
        updateCategory() {
            api.put(`/categories/${this.$route.params.id}`, {
                name: this.name,
            })
            .then((response) => {
                toastSuccess("Category updated successfully!");
                this.$router.push("/categories");
            })
            .catch((error) => {
                toastError(error.response.data.message);
            });
        }
    }
}

</script>
