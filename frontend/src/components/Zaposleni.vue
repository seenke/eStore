<template>
  <div id=all>
    <div id="zaposleni" class="containerCenter">
      <div id="aktivni">
        <h1 class="heading"><mark class="green">AKTIVIRANI</mark> UPORABNISKI RACUNI</h1>
        <Zaposlen v-for="account of this.zaposleni.activated" :zaposlen="account" :key="account.id" v-on:update="getAll">

        </Zaposlen>
      </div>
      <div>
        <button style="margin: auto" class="noviProdajalecBTN" @click="show">DODAJ NOVEGA PRODAJALCA</button>
      </div>
      <div id="dodajUporabnika">
        <modal name="my-first-modal" height="700">
          <div class="customer_container">
            <h1 id="name">Ime in Priimek</h1>
            <div class="addNew_field">
              <input type="text" placeholder="Ime" name="ime" required
                     v-model="userCredentials.name">
              <input type="text" placeholder="Priimek" name="priimek" required
                     v-model="userCredentials.lastname">
            </div>
            <h1 id="email">Email</h1>
            <div class="addNew_field">
              <input type="text" placeholder="Email" name="email" required
                     v-model="userCredentials.email">
            </div>
            <h1 id="password">Geslo</h1>
            <div class="addNew_field">
              <input placeholder="Geslo" name="geslo" required
                     v-model="userCredentials.password"
                     type="password">
            </div>
            <h1 id="confirmation_code">Konfirmacijska koda</h1>
            <div class="addNew_field">
              <input placeholder="Koda" name="koda" required
                     v-model="userCredentials.confirmation_code"
                     type="password">
            </div>
          </div>
          <button class="noviProdajalecBTN" style="margin-top: 4rem" @click="addNewCustomer">
            DODAJ NOVEGA PRODAJALCA
          </button>
        </modal>
      </div>
    </div>

    <div id="neaktivni">
      <h1 class="heading"><mark class="red">DEAKTIVIRANI</mark> UPORABNISKI RACUNI</h1>
      <Zaposlen v-for="account of this.zaposleni.deactivated" :zaposlen="account" :key="account.id" v-on:update="getAll">

      </Zaposlen>
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
.noviProdajalecBTN{
  display: flex;
  margin: 0 auto;
  padding-top: 5px;
  padding-bottom: 5px;
  padding-left: 15px;
  padding-right: 15px;
  background: #6cb33e;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  margin-bottom: 100px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

mark.green {
  color:#6cb33e;
  background: none;
}
mark.red {
  color:#BD0000;
  background: none;
}

.containerCenter{
  display: flex;
  align-items: center;
  justify-content: center;
  align-content: center;
}
.containerCenter2{
  display: flex;
  width: 60%;
  align-items: center;
  justify-content: center;
  align-content: center;
}
.addNew_field {
  display: flex;
  width: 60%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.addNew_field input {
  padding: 10px;
  text-align: center;
  width: 100%;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}
</style>