export default (baseUrl, apiVersion) => ({
  async createCourse(body) {
    return await axios.post(`${baseUrl}${apiVersion}/courses/create`, body);
  },

  async viewCourse(id) {
    return await axios.get(`${baseUrl}${apiVersion}/courses/${id}`);
  },

  async updateCourse(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/courses/${id}`, body);
  },

  async listCourses() {
    return await axios.get(`${baseUrl}${apiVersion}/courses`);
  }


});