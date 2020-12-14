import Vuex from 'vuex';
import ApiService from "@/services/service";
import axios from "axios";
import Vue from 'vue';

Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: localStorage.getItem('user') || {},
        shoppingCart: (localStorage.getItem('shoppingCart')) || {},
        fetchedCart: '',
        shoppingCartStatus: '',
        test: ''
    },
    mutations: {
        auth_request(state){
            state.status = 'loading'
        },
        auth_success(state, token, user){
            state.status = 'success'
            state.token = token
            console.log(user);
            state.user = JSON.stringify(user)
        },
        auth_error(state){
            state.status = 'error'
        },
        logout(state){
            state.status = ''
            state.token = ''
        },
        setShoppingCartSuccess (state, shoppingCart){
            state.shoppingCart = JSON.stringify(shoppingCart);
            state.fetched = Date.now().toString();
            state.shoppingCartStatus = 'success';
        },
        setShoppingCartError(state) {
            state.shoppingCartStatus = 'error'
        },
        updateShoppingCart(state, shoppingCart){
            state.shoppingCart = shoppingCart;
        },
        test(state){
            state.test = 'testing';
        },
        emptyShoppingCart(state) {
            state.shoppingCart = JSON.stringify([]);
        }
    },
    actions: {
        login({commit}, userData) {
            let apiService = new ApiService();
            return new Promise((resolve, reject)=> {
                apiService.loginUser(userData)
                    .then((data) => {
                        console.log(data)
                        const token = data.token
                        const user = data.user
                        localStorage.setItem('token', token);
                        localStorage.setItem('user', JSON.stringify(user));
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
        },
        getShoppingCart({commit}) {
            let apiService = new ApiService(this.getters.authToken);
            apiService.getSelfShoppingCart()
                .then((shoppingCart) => {
                    localStorage.setItem("shoppingCart", JSON.stringify(shoppingCart));
                    commit('setShoppingCartSuccess', shoppingCart);
                })
                .catch(() => {
                    commit('setShoppingCartError')
                })
        },
        updateShoppingCart({commit}, newItem) {
            let apiService = new ApiService(this.getters.authToken);
            console.log(this.getters.shoppingCart + " SHOPPING CART BEFORE")
            const currentCart = JSON.parse(this.getters.shoppingCart);
            let updateable = false;
            let requestData = {
                shoppingCart: []
            }
            console.log(currentCart)
            currentCart.forEach((storeItem) => {
                if (storeItem.id === newItem.id) {
                    storeItem.pivot.quantity += newItem.quantity;
                    updateable = true;
                }
                requestData.shoppingCart.push({
                    "id":storeItem.id,
                    "quantity":storeItem.pivot.quantity
                });
            })
            if (!updateable) {
               requestData.shoppingCart.push({
                   "id": newItem.id,
                   "quantity": newItem.quantity
               })
            }
            apiService.updateSelfShoppingCart(requestData)
                .then((updatedShoppingCart) => {
                    commit('updateShoppingCart', JSON.stringify(updatedShoppingCart));
                })
                .catch((err) => {
                    console.log(err);
                })
            console.log(requestData);
            commit('test');

        },
        emptyShoppingCart({commit}) {
            let apiService = new ApiService(this.getters.authToken);
            apiService.updateSelfShoppingCart({
                "shoppingCart":[]
            })
                .then(()=> {
                commit('emptyShoppingCart');
            })
                .catch((err) => {
                console.log(err);
            })
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        userRole: state => state.user.role,
        authToken: state => state.token,
        user: state => state.user,
        shoppingCart: state => state.shoppingCart,
        shoppingCartStatus: state => state.shoppingCartStatus

    }
})