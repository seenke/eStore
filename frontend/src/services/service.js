import axios from 'axios';


export default class ApiService {
    apiParameters = {
        "development": "http://127.0.0.1:8000/api/",
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

    createSelfOrder(orderData) {
        return new Promise((resolve, reject) =>  {
            axios.post(this.apiParameters.development + "user/self/order", orderData)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    getSelfOrders() {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "user/self/order")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    updateSelf(data) {
        return new Promise((resolve, reject) => {
            axios.put(this.apiParameters.development + "user/self", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    createSelfRating(data) {
        return new Promise((resolve, reject) => {
            axios.post(this.apiParameters.development + "user/self/rating", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    getOrders() {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "order")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    updateOrder(data) {
        return new Promise((resolve, reject) =>  {
            axios.put(this.apiParameters.development + "order", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    getAllUserAccounts () {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "userAccount")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    updateUserAccount (data) {
        return new Promise((resolve, reject) =>  {
            axios.put(this.apiParameters.development + "userAccount", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    deleteUserAccount (id) {
        return new Promise((resolve, reject) =>  {
            axios.delete(this.apiParameters.development + "userAccount/" + id)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    restoreUserAccount (id) {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "userAccount/restore/" + id)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    uploadPicture (data) {
        return new Promise((resolve, reject) =>  {
            axios.post(this.apiParameters.development + "picture", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    createStoreItem (data) {
        return new Promise((resolve, reject) =>  {
            axios.post(this.apiParameters.development + "storeItem", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    getStoreItem (id) {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "storeItem/"+id)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    updateStoreItem (data) {
        return new Promise((resolve, reject) =>  {
            axios.put(this.apiParameters.development + "storeItem/", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    creatUserAccount (data) {
        return new Promise((resolve, reject) =>  {
            axios.post(this.apiParameters.development + "userAccount", data)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    }

    loginAsSTAFF () {
        return new Promise((resolve, reject) =>  {
            axios.get(this.apiParameters.development + "cert/login")
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {                    reject(err);
                })
        })
    }
}