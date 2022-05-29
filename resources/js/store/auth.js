import axios from 'axios';
import router from '@/router';
import {apiRepositories as $api} from '@/services/api';


export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{}
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
       
    },
    actions:{
        async login({commit}){

          try{
            const response = await $api.auth.getProfile();
            commit('SET_USER',response.data);
            commit('SET_AUTHENTICATED',true);
            router.push({name:'dashboard'})
          }
          catch (e) {
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
          }
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        }
    }
}