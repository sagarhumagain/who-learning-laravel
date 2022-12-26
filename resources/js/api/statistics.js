
export default (baseUrl, apiVersion) => ({
  async fetchTopLearners() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/top-learners`);
  },
  async fetchAdminDashboardStats() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/admin-stats`);
  },
  async fetchStaffByPillar() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/staff-pillar`);
  },
  async fetchMostPopularCourses() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/course-popular`);
  },
  async fetchMandatoryCourses() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/course-mandatory`);
  },
  async fetchUserDashboardStats() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/user-stats`);
  },
  async fetchUserCompletedCourse() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/user-course-completed`);
  },
  async fetchUserUpcomingDeadlines() {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/user-course-deadline`);
  },
  async fetchUserYearlyProgress(year) {
    return await axios.get(`${baseUrl}${apiVersion}/statistics/user-yearly-progress?year=${year}`);
  },
  async fetchPendingApprovals() {
    return await axios.get(`${baseUrl}${apiVersion}/courses/users/pending-approval`);
  },
});
