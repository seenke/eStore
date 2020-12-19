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
import Kosarica from "@/components/Kosarica";
import Narocila from "@/components/Narocila";
import MojProfil from "@/components/MojProfil";
import Stranke from "@/components/Stranke";
import StoreItemCreator from "@/components/StoreItemCreator";
import StoreItemEditor from "@/components/StoreItemEditor";


Vue.use(VueSimpleAlert);
Vue.use(myCaptcha);
Vue.config.productionTip = false
Vue.use(VueRouter)
Vue.use(EasySlider)


const routes = [
  {path:'/', component: Home},
  {path: "/registracija", component: Registration},
  {path: "/prijava", component: Login },
  {path: "/trgovina", component: Trgovina},
  {path: "/kosarica", component: Kosarica},
  {path: "/narocila", component: Narocila},
  {path: "/mojProfil", component: MojProfil},
  {path: "/stranke", component: Stranke},
  {path: "/dodajIzdelek", component:StoreItemCreator},
  {path: "/uredi/:id", component: StoreItemEditor}
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
