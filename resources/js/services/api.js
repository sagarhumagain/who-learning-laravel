import { inject } from "vue";
import Auth from "@/api/auth";
// import Courses from "@/api/courses";

 // if (process.client) {
  //   const token = localStorage.getItem("token");
  //   // Set token when defined
  //   if (token) {
  //     context.$axios.setToken(token, "Bearer");
  //   }
  // }
  // Initialize API repositories
  const baseUrl = process.env.APP_URL;
  const apiVersion = '/api/v1';
  export const apiRepositories = {
    auth: Auth(baseUrl, apiVersion),
    // courses: Courses(baseUrl, apiVersion),
  };
  // inject("api", repositories);
