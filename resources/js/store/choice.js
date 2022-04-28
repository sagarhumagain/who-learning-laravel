import {apiRepositories as $api} from '@/services/api';

export default {
    namespaced: true,
    state:{
        pillars:[],
        staffTypes: [],
        contractTypes:[],
        staffCategories: [],
        designations: [],
        courseCategories: []
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
        }
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
          }
          catch (e) {
            // commit('SET_USER',{})
            // commit('SET_AUTHENTICATED',false)
          }
        }
    }
}