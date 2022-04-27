export default (baseUrl, apiVersion) => ({
  async getCsrfCookie() {
    return await axios.get(`${baseUrl}/sanctum/csrf-cookie`);
  },

  async login({email, password}) {
    return await axios.post(`${baseUrl}/login`, { email, password });
  },

  async logout() {
    return await axios.$et(`${baseUrl}/logout`);
  },

  async register(payload) {
    return await axios.post(`${baseUrl}/register`, payload);
  },

  async getActiveUser() {
    return await axios.get('/api/user');
  }
});