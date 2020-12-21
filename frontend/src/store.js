import Vuex from 'vuex';
import ApiService from "@/services/service";
import axios from "axios";
import Vue from 'vue';

Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: localStorage.getItem('user') || '',
        shoppingCart: (localStorage.getItem('shoppingCart')) || '',
        fetchedCart: '',
        shoppingCartStatus: '',
        test: '',
        orderStatus: ''
    },
    mutations: {
        auth_request(state){
            state.status = 'loading'
        },
        auth_success(state, payload){
            state.status = 'success'
            state.token = payload.token
            state.user = JSON.stringify(payload.user)
        },
        auth_error(state){
            state.status = 'error'
        },
        logout(state){
            state.status = ''
            state.token = ''
            state.user = ''
            state.shoppingCart = ''
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
        },
        placeOrderError(state) {
            state.orderStatus = 'oddaja narocila je spodletela';
        },
        placeOrderSuccess(state) {
            state.orderStatus = 'oddaja narocila je uspesna - narocilo  v obdelavi';
        },
        updateSelf(state, newData) {
            state.user = JSON.stringify(newData);
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
                        console.log(token, user, "ACTION LOGIN")
                        localStorage.setItem('token', token);
                        localStorage.setItem('user', JSON.stringify(user));
                        axios.defaults.headers.common['Authorization'] = token
                        const paylod = {
                            'token': token,
                            'user': user
                        };
                        commit('auth_success', paylod)
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
        loginSTAFF({commit}) {
          let apiService = new ApiService();
          return new Promise((resolve,reject) => {
              apiService.loginAsSTAFF()
                  .then((data) => {
                      const token = data.token;
                      const user = data.user;
                      localStorage.setItem('token', token);
                      localStorage.setItem('user', JSON.stringify(user));
                      axios.defaults.headers.common['Authorization'] = token
                      const paylod = {
                          'token': token,
                          'user': user
                      };
                      commit('auth_success', paylod)
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
            localStorage.removeItem('shoppingCart');
            commit('logout');
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
                if (storeItem.pivot.quantity !== 0) {
                    requestData.shoppingCart.push({
                        "id":storeItem.id,
                        "quantity":storeItem.pivot.quantity
                    });
                }
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
        },
        placeOrder({commit}) {
            return new Promise ((resolve,reject) => {

                let apiService = new ApiService(this.getters.authToken);
                const currentCart = JSON.parse(this.getters.shoppingCart);
                let requestData = {
                    "orderItems" : []
                };
                currentCart.forEach((cartItem) => {
                    requestData.orderItems.push({
                        "id": cartItem.id,
                        "quantity": cartItem.pivot.quantity,
                        "price": cartItem.price
                    });
                })
                apiService.createSelfOrder(requestData)
                    .then(()=>{
                        commit('placeOrderSuccess');
                        resolve();
                    })
                    .catch(()=> {
                        commit('placeOrderError')
                        reject();
                    })
            })
        },
        updateSelf({commit}, newData) {
            localStorage.setItem("user", JSON.stringify(newData));
            commit('updateSelf', newData);
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        userRole: (state) => {
            console.log(state.user + " STATE USER")
            if (state.user === {} || state.user === '' || state.user === undefined) {
                return 'anonymous';
            }
            else {
                return JSON.parse(state.user).role
            }

        }
        ,
        authToken: state => state.token,
        user: state => state.user,
        shoppingCart: state => state.shoppingCart,
        shoppingCartStatus: state => state.shoppingCartStatus,
        orderStatus: state => state.orderStatus,
    }
})