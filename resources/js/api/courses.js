export default (baseUrl, apiVersion) => ({
  async create(body) {
    return await axios.post(`${baseUrl}${apiVersion}/courses`, body);
  },

  async view(id) {
    return await axios.get(`${baseUrl}${apiVersion}/courses/${id}`);
  },

  async update(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/courses/${id}`, body);
  },

  async list() {
    return await axios.get(`${baseUrl}${apiVersion}/courses`);
  }
});