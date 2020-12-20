<template>
  <div id="stranke">
    <div id="aktivni" class="stranka_container">
      <h1><mark class="green">AKTIVIRANI</mark> UPORABNISKI RACUNI</h1>
      <div v-for="userAccount in userAccounts.activated" :key="userAccount.id">
        <stranka :stranka="userAccount" v-on:updated="getAllUserAccounts"></stranka>
      </div>
    </div>
    <div id="neaktivni" class="stranka_container">
      <h1><mark class="red">DEAKTIVIRANI</mark> UPORABNISKI RACUNI</h1>
      <div v-for="userAccount in userAccounts.deactivated" :key="userAccount.id" >
        <stranka :stranka="userAccount" v-on:updated="getAllUserAccounts"></stranka>
      </div>
    </div>
    <button style="display: block;margin: auto; margin: 100px;" class="addUporabnika" @click="show">DODAJ STRANKO</button>
    <modal name="my-first-modal" height="700">
      <div class="customer_container">
        <h1 id="name">Ime in Priimek</h1>
        <div class="addNew_field">
          <input type="text" placeholder="Vaše ime" name="ime" required
                 v-model="userCredentials.accountData.name">
          <input type="text" placeholder="Vaš priimek" name="priimek" required
                 v-model="userCredentials.accountData.lastname">
        </div>
        <h1 id="email">Email</h1>
        <div class="addNew_field">
          <input type="text" placeholder="Vaš email" name="email" required
                 v-model="userCredentials.accountData.email">
        </div>

        <h1 id="password">Geslo</h1>
        <div class="addNew_field">
          <input type="password" placeholder="Vaše geslo" name="geslo" required
                 v-model="userCredentials.accountData.password">
        </div>

        <h1 id="address">Naslov in hišna številka</h1>
        <div class="addNew_field">
          <input type="text" placeholder="Naslov" name="naslov" required
                 v-model="userCredentials.addressData.street">
          <input type="text" placeholder="Št." name="hisna_stevilka" required
                 v-model="userCredentials.addressData.street_number">
        </div>

        <h1 id="postoffice">Posta in postna stevilka</h1>
        <div class="addNew_field">
          <input type="text" placeholder="Posta" name="posta" required
                 v-model="userCredentials.postOfficeData.post_office">
          <input type="text" placeholder="Postna Št." name="postna_st" required
                 v-model="userCredentials.postOfficeData.postal_code">
        </div>
      </div>
      <button class="stranka_add" style="margin-top: 4rem;" @click="addNewCustomer">
        DODAJ NOVO STRANKO
      </button>
    </modal>
  </div>

</template>

<script>
import ApiService from "@/services/service";
import Stranka from "@/components/Stranka";
export default {
  name: "Stranke",
  components: {
    Stranka
  },
  data: function () {
    return {
      "userAccounts": {},
      userCredentials: {
        "accountData" : {
          "name": '',
          "lastname": '',
          "email": '',
          "password": '',
          "role": "customer"
        },
        "addressData" : {
          "street" : '',
          "street_number" : ''
        },
        "postOfficeData" : {
          "post_office" : '',
          "postal_code": ''
        }
      }
    }
  },
  methods: {
    "getAllUserAccounts": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.getAllUserAccounts()
          .then((response) => {
            this.userAccounts = response;
          })
          .catch(()=> {
            this.$alert("Prislo je do napake pri pridobivanju uporabniskih racunov",  "Napaka", "error");
          })
    },
    show () {
      this.$modal.show('my-first-modal');
    },
    hide () {
      this.$modal.hide('my-first-modal');
    },
    addNewCustomer() {
      const apiService = new ApiService(this.$store.getters.authToken);
      console.log(this.userCredentials)
      apiService.registerUser(this.userCredentials)
          .then(()=> {
            this.$alert('Uspesno dodana nova stranka', 'Stranka', 'success');
            this.hide();
            this.userCredentials = {
              "accountData" : {
                "name": '',
                "lastname": '',
                "email": '',
                "password": '',
                "role": "customer"
              },
              "addressData" : {
                "street" : '',
                "street_number" : ''
              },
              "postOfficeData" : {
                "post_office" : '',
                "postal_code": ''
              }
            };
          })
          .catch((err)=> {
            console.log(err.response);
            this.$alert('Napaka pri dodajanju nove stranke', 'Napaka', 'error');
          })
    }
  },
  beforeMount() {
    this.getAllUserAccounts();
  },
  mounted() {

  }

}
</script>

<style scoped>
.addUporabnika{
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
.customer_container input {
  display: block;
  margin: auto;
  margin-top: 1rem;
}
mark.green {
  color:#6cb33e;
  background: none;
}
mark.red {
  color:#BD0000;
  background: none;
}
.customer_container{
  text-align: center;
}
.stranka_container{
  display: inline-block;
  color: white;
  margin-left: 1rem;
}
.stranka_add {
  display: block;
  margin-top: 4rem;
  margin-left: 15rem;
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
.modal {
  height: 50rem;
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