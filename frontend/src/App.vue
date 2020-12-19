<template>
  <div id="app">
    <div id="nav">
      <ul v-if="$store.getters.userRole === 'customer' || $store.getters.userRole === 'anonymous'">
        <router-link to="/prijava" v-if="!isLoggedIn"><li> PRIJAVA </li></router-link>
        <li id="logout" @click="logout" v-if="isLoggedIn"><a>ODJAVA</a></li>
        <router-link to="/trgovina"><li> TRGOVINA </li></router-link>
        <router-link to="/narocila" v-if="isLoggedIn"><li>NAROCILA</li></router-link>
        <router-link to="/"><li>DOMOV</li></router-link>
        <router-link to="/mojProfil" v-if="isLoggedIn"><li>MOJ PROFIL</li></router-link>
        <router-link to="/kosarica" v-if="isLoggedIn"><li>KOSARICA</li></router-link>
      </ul>

      <ul v-if="$store.getters.userRole === 'Seller'">
        <li @click="logout" v-if="isLoggedIn"><a>ODJAVA</a></li>
        <router-link to="/narocila"><li>NAROCILA</li></router-link>
        <router-link to="/trgovina"><li>TRGOVINA</li></router-link>
        <router-link to="/dodajIzdelek"><li>DODAJ IZDELEK</li></router-link>
        <router-link to="/mojProfil"><li>MOJ PROFIL</li></router-link>
        <router-link to="/stranke"><li>STRANKE</li></router-link>
      </ul>
      <ul v-if="$store.getters.userRole === 'admin'">
        <li @click="logout" v-if="isLoggedIn"><a>ODJAVA</a></li>
        <router-link to="/mojProfil"><li>MOJ PROFIL</li></router-link>
        <router-link to="/zaposleni"><li>ZAPOSLENI</li></router-link>
      </ul>
    </div>

    <div class="logo">
      <div class="logo_svg">
        <img src="./assets/leaf.svg" alt="error">
      </div>
      <h1>eStore</h1>
      <p>TUKAJ SMO ZA VAS ZE OD LETA 2020</p>
    </div>


    <div class="main-content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Home from './components/Home.vue'
/* eslint-disable vue/no-unused-components */

export default {
  name: 'App',
  components: {
    Home
  },
  computed: {
    isLoggedIn: function (){
      return this.$store.getters.isLoggedIn;
    }
  },
  methods: {
    "logout": function () {
      this.$store.dispatch('logout');
      this.$router.push("/")
    }
  }
}
</script>

<style scoped>
#logout a:hover {
  cursor: pointer;
}
.logo_svg {
  width: 5em;
  margin: 1% 49%;
}
.logo_svg img {
  color: white;
  fill: white;
}
#app {
  width: 100%;
}
.main-content {
  display: flex;
  align-items: center;
  justify-content: center;
}
#nav {
  position: absolute;
  left: 0px;
  height: 40px;
  width: 100%;
  display: flex;
  justify-content: center;
}
#nav ul {
  margin: 0;
  padding: 0;
}
#nav ul li {
  margin: 0;
  padding: 0;
  float:left;
}
#nav ul li  {
  text-decoration: none;
  padding: 30px 20px;
  display: block;
  color: #6cb33e;
  text-align: center;
  font-weight: bold;
  font-size: 24px;
}
.logo {
  text-align: center;
  padding-top: 10%;
  padding-bottom: 5%;
}
.logo h1 {
  font-weight: bold;
  color: #6cb33e;
  font-size: 64px;
}
.logo p {
  padding-top: 1%;
  color: white;
  font-weight: bold;
}
</style>
