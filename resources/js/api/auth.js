import store from '@/store';
import axios from 'axios';
const api = axios.create({
    headers: {
      'Content-Type': 'application/json',
      '_token': document.querySelector('meta[name="csrf-token"]').content,
    }
  });

export default (baseUrl, apiVersion ) => ({
  async login({email, password}) {
    console.log(document.querySelector('meta[name="csrf-token"]').content);
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
    console.log(`${baseUrl}${apiVersion}/profile`);
    return await api.get(`${baseUrl}${apiVersion}/profile`);
  },
  async getAuthRoles() {
    return await api.get(`${baseUrl}${apiVersion}/auth-permissions`);
  },
  async getAuthPermissions() {
    return await api.get(`${baseUrl}${apiVersion}/auth-roles`);
  },
});
