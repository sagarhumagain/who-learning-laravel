
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

    async filterMostPopularCourses(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/course-popular?start_date=${start_date}&end_date=${end_date}`);
    },
    async filterStaffByPillar(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/staff-pillar?start_date=${start_date}&end_date=${end_date}`);
    },
    async filterAdminDashboardStats(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/admin-stats?start_date=${start_date}&end_date=${end_date}`);
    },

    async filterUserDashboardStats(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/user-stats?start_date=${start_date}&end_date=${end_date}`);
    },
    async filterUserCompletedCourse(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/user-course-completed?start_date=${start_date}&end_date=${end_date}`);
    },
    async filterUserUpcomingDeadlines(start_date, end_date) {
        return await axios.get(`${baseUrl}${apiVersion}/statistics/user-course-deadline?start_date=${start_date}&end_date=${end_date}`);
    }







});
