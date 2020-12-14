import axios from 'axios';


export default class ApiService {
    apiParameters = {
        "development": "http://127.0.0.1:8001/api/",
        "production" : "TODO"
    }

    constructor(authToken) {
        if (authToken === '') {
            return
        }
        axios.defaults.headers.common['Authorization'] = "Bearer " + authToken
    }

    getPostOffices() {
        return new Promise((resolve, reject) => {
            axios.get(this.apiParameters.development + "postOffice")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    }

    registerUser(userData) {
        return new Promise((resolve, reject) => {
            axios.post(this.apiParameters.development + "user", userData)
                .then((response) => {
                    resolve(response.data)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }

    confirmAccount(userData) {
        return new Promise((resolve, reject) => {
            axios.post(this.apiParameters.development + "confirm", userData)
                .then((response) => {
                    resolve(response.data)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }

    loginUser (userData) {
        return new Promise((resolve, reject) => {
            axios.post(this.apiParameters.development + "login", userData)
                .then((response) => {
                    resolve(response.data)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }

    getStoreItems () {
        return new Promise((resolve, reject) => {
            axios.get(this.apiParameters.development + "storeItem")
                .then((response) => {
                    resolve(response.data)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }

    getSelfShoppingCart() {
        return new Promise((resolve, reject) => {
            axios.get(this.apiParameters.development + "user/self/shoppingCart")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    }

    updateSelfShoppingCart(shoppingCart) {
        return new Promise((resolve, reject) => {
            axios.put(this.apiParameters.development + "user/self/shoppingCart", shoppingCart)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    }
}