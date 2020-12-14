import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'

import store from "@/store";

//Route components
import Home from "./components/Home.vue";
import Registration from "@/components/Registration";
import Login from "@/components/Login";
import VueSimpleAlert from "vue-simple-alert";
import EasySlider from 'vue-easy-slider';
import myCaptcha from 'vue-captcha'
import Trgovina from "@/components/Trgovina";


Vue.use(VueSimpleAlert);
Vue.use(myCaptcha);
Vue.config.productionTip = false
Vue.use(VueRouter)
Vue.use(EasySlider)


const routes = [
  {path:'/', component: Home},
  {path: "/registracija", component: Registration},
  {path: "/prijava", component: Login },
  {path: "/trgovina", component: Trgovina}
]

const router = new VueRouter({
  routes,
  mode: 'history'
})

new Vue({
  router:router,
  store:store,
  render: h => h(App)
}).$mount('#app')
