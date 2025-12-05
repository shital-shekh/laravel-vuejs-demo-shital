import axios from "axios";
import router from "../router";
import { toastError } from "../utils/toast";

// Create instance
const api = axios.create({
  baseURL: "/api",
  headers: {
    Accept: "application/json",
  }
});

// -----------------------------
// REQUEST INTERCEPTOR
// -----------------------------
api.interceptors.request.use((config) => {

  // Get token from localStorage
  const token = localStorage.getItem("token");

  // If token exists, attach to every request
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;

}, (error) => {
  return Promise.reject(error);
});

// -----------------------------
// RESPONSE INTERCEPTOR
// -----------------------------
api.interceptors.response.use(
  (response) => {
    return response; // return normally
  },

  (error) => {

    // If token expired / invalid → Laravel returns 401
    if (error.response && error.response.status === 401) {

      toastError("Session expired. Please login again.");

      // Clear token
      localStorage.removeItem("token");

      // Redirect to login
      router.push("/");
    }

    return Promise.reject(error);
  }
);

export default api;
