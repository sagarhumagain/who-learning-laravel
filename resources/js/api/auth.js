import store from '@/store';
export default (baseUrl, apiVersion ) => ({
  async getCsrfCookie() {
    return await axios.get(`${baseUrl}/sanctum/csrf-cookie`);
  },
  async login({email, password}) {
    console.log(`${baseUrl}/login`, apiVersion);
    return await axios.post(`${baseUrl}/login`, { email, password });
  },

  async logout() {
    return await axios.get(`${baseUrl}/logout`);
  },

  async customLogout() {
    return await axios.get(`${baseUrl}${apiVersion}/custom-logout/`);
  },

  async register(payload) {
    return await axios.post(`${baseUrl}/register`, payload);
  },

  async getActiveUser() {
    return await axios.get('/api/user');
  },
  async getProfile() {
    return await axios.get(`${baseUrl}${apiVersion}/profile`);
  },
  async getAuthRoles() {
    return await axios.get(`${baseUrl}${apiVersion}/auth-permissions`);
  },
  async getAuthPermissions() {
    return await axios.get(`${baseUrl}${apiVersion}/auth-roles`);
  },
});
