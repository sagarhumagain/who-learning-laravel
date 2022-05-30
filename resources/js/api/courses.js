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
  },

  async listUnapprovedCourse() {
    return await axios.get(`${baseUrl}${apiVersion}/approvals/courses`);
  },
  async listSuggestedCourse() {
    return await axios.get(`${baseUrl}${apiVersion}/suggest/courses`);
  },
  async enrollToCourse(body={}) {
    return await axios.post(`${baseUrl}${apiVersion}/enroll/course`, body);
  },
  async listUserEnrolledCourses() {
    return await axios.get(`${baseUrl}${apiVersion}/course_user`);
  },
  async getExceededDeadlines() {
    return await axios.get(`${baseUrl}${apiVersion}/deadlines-exceed`);
  }
});