import {apiRepositories as $api} from '@/services/api';

export default {
    namespaced: true,
    state:{
        pillars:[],
        staffTypes: [],
        contractTypes:[],
        staffCategories: [],
        designations: [],
        courseCategories: [],
        contractTypeDesignation: [],
        contractTypeStaffCategory: [],
        contractTypeStaffType: [],
        designationStaffCategory: [],
        designationStaffType: [],
        staffCategoryStaffType: [],
        supervisors: [],

    },
    getters:{
        pillars(state){
            return state.pillars
        },
        staffTypes(state){
            return state.staffTypes
        },
        contractTypes(state){
          return state.contractTypes
        },
        staffCategories(state){
          return state.staffCategories
        },
        designations(state){
          return state.designations
        },
        courseCategories(state){
          return state.courseCategories
        },
        contractTypeDesignation(state) {
          return state.contractTypeDesignation
        },
        contractTypeStaffCategory(state) {
          return state.contractTypeStaffCategory
        },
        contractTypeStaffType(state) {
          return state.contractTypeStaffType
        },
        designationStaffCategory(state) {
          return state.designationStaffCategory
        },
        designationStaffType(state) {
          return state.designationStaffType
        },
        staffCategoryStaffType(state) {
          return state.staffCategoryStaffType
        },
        supervisors(state) {
          return state.supervisors
        },
    },
    mutations:{
        SET_PILLARS (state, value) {
            state.pillars = value
        },
        SET_STAFF_TYPES (state, value) {
            state.staffTypes = value
        },
        SET_CONTRACT_TYPES (state, value) {
          state.contractTypes = value
        },
        SET_STAFF_CATEGORIES (state, value) {
          state.staffCategories = value
        },
        SET_DESIGNATIONS (state, value) {
          state.designations = value
        },
        SET_COURSE_CATEGORIES (state, value) {
          state.courseCategories = value
        },
        SET_CONTRACT_TYPE_DESIGNATION (state, value) {
          state.contractTypeDesignation = value
        },
        SET_CONTRACT_TYPE_STAFF_CATEGORY (state, value) {
          state.contractTypeStaffCategory = value
        },
        SET_CONTRACT_TYPE_STAFF_TYPE (state, value) {
          state.contractTypeStaffType = value
        },
        SET_DESIGNATION_STAFF_CATEGORY (state, value) {
          state.designationStaffCategory = value
        },
        SET_DESIGNATION_STAFF_TYPE (state, value) {
          state.designationStaffType = value
        },
        SET_STAFF_CATEGORY_STAFF_TYPE (state, value) {
          state.staffCategoryStaffType = value
        },
        SET_SUPERVISORS (state, value) {
          state.supervisors = value
        },
    },
    actions:{
        async setEnums({commit}){
          try{
            let response = await $api.enums.listPillar();
            commit('SET_PILLARS',response.data);
            response = await $api.enums.listStaffType();
            commit('SET_STAFF_TYPES',response.data);
            response = await $api.enums.listContractType();
            commit('SET_CONTRACT_TYPES',response.data);
            response = await $api.enums.listStaffCategory();
            commit('SET_STAFF_CATEGORIES',response.data);
            response = await $api.enums.listDesignation();
            commit('SET_DESIGNATIONS',response.data);
            response = await $api.enums.listCourseCategory();
            commit('SET_COURSE_CATEGORIES',response.data);
            //validations store
            response = await $api.enums.contractTypeDesignation();
            commit('SET_CONTRACT_TYPE_DESIGNATION',response.data);
            response = await $api.enums.contractTypeStaffCategory();
            commit('SET_CONTRACT_TYPE_STAFF_CATEGORY',response.data);
            response = await $api.enums.contractTypeStaffType();
            commit('SET_CONTRACT_TYPE_STAFF_TYPE',response.data);
            response = await $api.enums.designationStaffCategory();
            commit('SET_DESIGNATION_STAFF_CATEGORY',response.data);
            response = await $api.enums.designationStaffType();
            commit('SET_DESIGNATION_STAFF_TYPE',response.data);
            response = await $api.enums.staffCategoryStaffType();
            commit('SET_STAFF_CATEGORY_STAFF_TYPE',response.data);
            response = await $api.enums.supervisors();
            commit('SET_SUPERVISORS',response.data);

          }
          catch (e) {
            // commit('SET_USER',{})
            // commit('SET_AUTHENTICATED',false)
          }
        }
    }
}
