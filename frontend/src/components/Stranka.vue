<template>
  <div id="stranka" class="card2">
    <div class="credentials">
      <h3>OSEBNI PODATKI</h3>
      <ul class="addNew_field">
        <li><input v-model="stranka.name" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.lastname" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.email" :disabled="stranka.deleted_at !== null"></li>
      </ul>
    </div>
    <div class="credentials">
      <h3>NASLOV</h3>
      <ul class="addNew_field">
        <li><input v-model="stranka.address.street" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.address.street_number" :disabled="stranka.deleted_at !== null"></li>
      </ul>
    </div>
    <div class="credentials">
      <h3>POSTA</h3>
      <ul class="addNew_field">
        <li><input v-model="stranka.postOffice.postal_code" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.postOffice.post_office" :disabled="stranka.deleted_at !== null"></li>
      </ul>
    </div>
    <button class="aktivirajUporabnika" @click="updateUserAccount" v-if="stranka.deleted_at === null">
      POSODOBI UPORABNIKA
    </button>
    <button class="deaktivirajUporabnika" @click="deactivateAccount" v-if="stranka.deleted_at === null">
      DEAKTIVIRAJ UPORABNIKA
    </button>
    <button class="aktivirajUporabnika" @click="activateAccount" v-if="stranka.deleted_at !== null">
      AKTIVIRAJ UPORABNIKA
    </button>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "Stranka",
  props: ['stranka'],
  methods: {
    "updateUserAccount": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      console.log("updating user with id " + this.stranka.id)
      console.log(this.stranka)
      apiService.updateUserAccount(this.stranka)
          .then((response)=> {
            console.log(response);
            this.$alert('Uporabniski racnu  uspesno posodobljen', 'Posodobitev', 'success');
            this.$emit("updated");
          })
          .catch((err) => {
            console.log(err.response)
            this.$alert('Napaka pri posodobitvi uporaarbniskega racnua', 'Napaka', 'error');
          })
    },
    "deactivateAccount": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.deleteUserAccount(this.stranka.id)
          .then(()=> {
            this.$emit("updated");
            this.$alert('Uporabnik uspesno deaktiviran', 'Status', 'success');
          })
          .catch(() => {
            this.$alert('Napaka pri deaktivaciji uporabnika', 'Napaka', 'error');
          })
    },
    "activateAccount": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.restoreUserAccount(this.stranka.id)
          .then(()=> {
            this.$emit("updated");
            this.$alert('Uporabnik uspesno aktiviran', 'Status', 'success');
          })
          .catch(()=> {
            this.$alert('Napaka pri aktivaciji uporabnika', 'Napaka', 'error');
          })
    }
  }
}
</script>

<style scoped>
.credentials{
  text-align: center;
  margin-bottom: 0.5rem;
}
.credentials ul {
  list-style: none;
}
#stranka {
  margin-bottom: 1.5rem;
}
#stranka button {
  margin-left: 4rem;
}
.deaktivirajUporabnika {
  margin: 0 auto;
  padding-top: 5px;
  padding-bottom: 5px;
  padding-left: 15px;
  padding-right: 15px;
  background: #BD0000;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.aktivirajUporabnika{
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

.card2 {
  border-radius: 25px;
  padding-top: 20px;
  padding-bottom: 20px;
  width: 545px;
  height: 200px;
  align: center;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
  margin-bottom: 10px;
}
</style>