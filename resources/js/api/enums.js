import axios from "axios";

export default (baseUrl, apiVersion) => ({
  async createPillar(body) {
    return await axios.post(`${baseUrl}${apiVersion}/pillars`, body);
  },

  async viewPillar(id) {
    return await axios.get(`${baseUrl}${apiVersion}/pillars/${id}`);
  },

  async updatePillar(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/pillars/${id}`, body);
  },

  async listPillar() {
    return await axios.get(`${baseUrl}${apiVersion}/pillars`);
  },

  async createContractType(body) {
    return await axios.post(`${baseUrl}${apiVersion}/contract-types`, body);
  },

  async viewContractType(id) {
    return await axios.get(`${baseUrl}${apiVersion}/contract-types/${id}`);
  },

  async updateContractType(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/contract-types/${id}`, body);
  },

  async listContractType() {
    return await axios.get(`${baseUrl}${apiVersion}/contract-types`);
  },

  async createStaffType(body) {
    return await axios.post(`${baseUrl}${apiVersion}/staff-types`, body);
  },

  async viewStaffType(id) {
    return await axios.get(`${baseUrl}${apiVersion}/staff-types/${id}`);
  },

  async updateStaffType(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/staff-types/${id}`, body);
  },

  async listStaffType() {
    return await axios.get(`${baseUrl}${apiVersion}/staff-types`);
  },

  async createStaffCategory(body) {
    return await axios.post(`${baseUrl}${apiVersion}/staff-categories`, body);
  },

  async viewStaffCategory(id) {
    return await axios.get(`${baseUrl}${apiVersion}/staff-categories/${id}`);
  },

  async updateStaffCategory(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/staff-categories/${id}`, body);
  },

  async listStaffCategory() {
    return await axios.get(`${baseUrl}${apiVersion}/staff-categories`);
  },

  async createDesignation(body) {
    return await axios.post(`${baseUrl}${apiVersion}/designations`, body);
  },

  async viewDesignation(id) {
    return await axios.get(`${baseUrl}${apiVersion}/designations/${id}`);
  },

  async updateDesignation(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/designations/${id}`, body);
  },

  async listDesignation() {
    return await axios.get(`${baseUrl}${apiVersion}/designations`);
  },

  async createCourseCategory(body) {
    return await axios.post(`${baseUrl}${apiVersion}/course-categories`, body);
  },

  async viewCourseCategory(id) {
    return await axios.get(`${baseUrl}${apiVersion}/course-categories/${id}`);
  },

  async updateCourseCategory(body) {
    return await axios.patch(`${baseUrl}${apiVersion}/course-categories/${id}`, body);
  },

  async listCourseCategory() {
    return await axios.get(`${baseUrl}${apiVersion}/course-categories`);
  },

  async contractTypeDesignation() {
    return await axios.get(`${baseUrl}${apiVersion}/contract-type-designation`);
  },

  async contractTypeStaffCategory() {
    return await axios.get(`${baseUrl}${apiVersion}/contract-type-staff-category`);
  },

  async contractTypeStaffType() {
    return await axios.get(`${baseUrl}${apiVersion}/contract-type-staff-type`);
  },

  async designationStaffCategory() {
    return await axios.get(`${baseUrl}${apiVersion}/designation-staff-category`);
  },

  async designationStaffType() {
    return await axios.get(`${baseUrl}${apiVersion}/designation-staff-type`);
  },

  async staffCategoryStaffType() {
    return await axios.get(`${baseUrl}${apiVersion}/staff-category-staff-type`);
  },
  async supervisors() {
    return await axios.get(`${baseUrl}${apiVersion}/supervisors`);
  },
  async units() {
    return await axios.get(`${baseUrl}${apiVersion}/units`);
  }
});
