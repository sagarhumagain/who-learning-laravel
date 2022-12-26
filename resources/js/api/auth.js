import store from '@/store';
export default (baseUrl, apiVersion ) => ({
  async getCsrfCookie() {
    return await axios.get(`${baseUrl}/sanctum/csrf-cookie`);
  },
  async login({email, password}) {
    return await axios.post(`${baseUrl}/login`, { email, password }, {
        headers: {
          'Content-Type': 'application/json'
        }
      });
  },
  async logout() {
    return await axios.get(`${baseUrl}/logout`);
  },

  async customLogout() {
    return await axios.get(`${baseUrl}${apiVersion}/custom-logout/`);
  },

  async register(payload) {
    return await axios.post(`${baseUrl}/register`, payload, {
        headers: {
            'Content-Type': 'application/json'
        }
    });
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
