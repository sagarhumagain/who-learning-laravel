import { inject } from "vue";
import Auth from "@/api/auth";
import Notification from "@/api/notification";
import Courses from "@/api/courses";
import Enums from "@/api/enums";
import Statistics from "@/api/statistics";
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
    notification: Notification(baseUrl, apiVersion),
    courses: Courses(baseUrl, apiVersion),
    enums: Enums(baseUrl, apiVersion),
    statistics: Statistics(baseUrl, apiVersion)
  };
  // inject("api", repositories);
