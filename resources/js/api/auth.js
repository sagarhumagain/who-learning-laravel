import store from '@/store';
import axios from 'axios';
const api = axios.create({
    headers: {
      'Content-Type': 'application/json'
    }
  });
export default (baseUrl, apiVersion ) => ({
  async getCsrfCookie() {
    return await api.get(`${baseUrl}/sanctum/csrf-cookie`);
  },
  async login({email, password}) {
    return await api.post(`${baseUrl}/login`, { email, password });
  },

  async logout() {
    return await api.get(`${baseUrl}/logout`);
  },

  async customLogout() {
    return await api.get(`${baseUrl}${apiVersion}/custom-logout/`);
  },

  async register(payload) {
    return await api.post(`${baseUrl}/register`, payload);
  },

  async getActiveUser() {
    return await api.get('/api/user');
  },
  async getProfile() {
    return await api.get(`${baseUrl}${apiVersion}/profile`);
  },
  async getAuthRoles() {
    return await api.get(`${baseUrl}${apiVersion}/auth-permissions`);
  },
  async getAuthPermissions() {
    return await api.get(`${baseUrl}${apiVersion}/auth-roles`);
  },
});
