import Vuex from 'vuex';
import ApiService from "@/services/service";
import axios from "axios";
import Vue from 'vue';

Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: localStorage.getItem('user') || {}
    },
    mutations: {
        auth_request(state){
            state.status = 'loading'
        },
        auth_success(state, token, user){
            state.status = 'success'
            state.token = token
            state.user = user
        },
        auth_error(state){
            state.status = 'error'
        },
        logout(state){
            state.status = ''
            state.token = ''
        }
    },
    actions: {
        login({commit}, userData) {
            let apiService = new ApiService();
            return new Promise((resolve, reject)=> {
                apiService.loginUser(userData)
                    .then((data) => {
                        const token = data.token
                        const user = data.user
                        localStorage.setItem('token', token)
                        localStorage.setItem('user', user);
                        axios.defaults.headers.common['Authorization'] = token
                        commit('auth_success', token, user)
                        resolve(data)
                    })
                    .catch((err)=> {
                        commit('auth_error')
                        localStorage.removeItem('token')
                        localStorage.removeItem('user');
                        reject(err)
                    })
            })
        },
        logout({commit}) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            commit('logout');
            this.$router.push("/");
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        userRole: state => state.user.role,
        authToken: state => state.token
    }
})