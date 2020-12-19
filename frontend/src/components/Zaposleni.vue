<template>
  <div id="zaposleni">
    <div id="aktivni">
      <h1 class="heading">AKTIVIRANI UPORABNISKI RACUNI</h1>
      <Zaposlen v-for="account of this.zaposleni.activated" :zaposlen="account" :key="account.id" v-on:update="getAll">

      </Zaposlen>
    </div>
    <div id="neaktivni">
      <h1 class="heading">DEAKTIVIRANI UPORABNISKI RACUNI</h1>
      <Zaposlen v-for="account of this.zaposleni.deactivated" :zaposlen="account" :key="account.id" v-on:update="getAll">

      </Zaposlen>
    </div>
    <button style="display: block;margin: auto" @click="show">DODAJ NOVEGA PRODAJALCA</button>
    <div id="dodajUporabnika">
      <modal name="my-first-modal" height="700">
        <div class="customer_container">
          <h1 id="name">Ime in Priimek</h1>
          <div class="register_field">
            <input type="text" placeholder="Ime" name="ime" required
                   v-model="userCredentials.name">
            <input type="text" placeholder="Priimek" name="priimek" required
                   v-model="userCredentials.lastname">
          </div>
          <h1 id="email">Email</h1>
          <div class="register_field">
            <input type="text" placeholder="Email" name="email" required
                   v-model="userCredentials.email">
          </div>
          <h1 id="password">Geslo</h1>
          <div class="register_field">
            <input placeholder="Geslo" name="geslo" required
                   v-model="userCredentials.password"
                   type="password">
          </div>
          <h1 id="confirmation_code">Konfirmacijska koda</h1>
          <div class="register_field">
            <input placeholder="Koda" name="koda" required
                   v-model="userCredentials.confirmation_code"
                   type="password">
          </div>
        </div>
        <button class="stranka_add" style="margin-top: 4rem" @click="addNewCustomer">
          DODAJ NOVEGA PRODAJALCA
        </button>
      </modal>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";
import Zaposlen from "@/components/Zaposlen";

export default {
  name: "Zaposleni",
  components: {Zaposlen},
  data: function () {
    return{
      "zaposleni": [],
      "userCredentials": {
        "name": '',
        "lastname": '',
        "email": '',
        "password": '',
        "confirmation_code":''
      }
    }
  },
  methods: {
    getAll: function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.getAllUserAccounts()
          .then((accounts) => {
            console.log(accounts);
            this.zaposleni = accounts;
          })
          .catch((err)=> {
            console.log(err.response);
          })
    },show () {
      this.$modal.show('my-first-modal');
    },
    hide () {
      this.$modal.hide('my-first-modal');
    },
    addNewCustomer() {
      console.log(this.userCredentials)
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.creatUserAccount(this.userCredentials)
        .then((response)=> {
          console.log(response);
        })
        .catch((err)=> {
          console.log(err.response)
        })
    }
  },
  mounted() {
    this.getAll();
  }
}
</script>

<style scoped>
.heading{
  color: white;
}
#zaposleni div {
  display: inline-block;
}
.customer_container input {
  display: block;
  margin: auto;
  margin-top: 1rem;
}
.customer_container{
  text-align: center;
}
.stranka_container{
  display: inline-block;
  color: white;
  margin-left: 1rem;
}
</style>