import axios from 'axios';


export default class ApiService {
    apiParameters = {
        "development": "http://127.0.0.1:8001/api/",
        "production" : "TODO"
    }

    constructor(authToken) {
        console.log(authToken === '')
        if (authToken === '') {
            return
        }
        console.log("setting")
        axios.defaults.headers.common['Authorization'] = "Bearer " + authToken
        console.log(authToken + " SET TO AUTHORIZATION HEADERS")
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
        console.log(axios.defaults.headers.common['Authorization']  + "GET STORE ITEMS  ")
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
}