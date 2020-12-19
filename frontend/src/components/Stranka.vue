<template>
  <div id="stranka">
      <div class="credentials">
        <h3>OSEBNI PODATKI</h3>
        <ul>
        <li><input v-model="stranka.name" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.lastname" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.email" :disabled="stranka.deleted_at !== null"></li>
        </ul>
      </div>
      <div class="credentials">
        <h3>NASLOV</h3>
        <ul>
          <li><input v-model="stranka.address.street" :disabled="stranka.deleted_at !== null"></li>
          <li><input v-model="stranka.address.street_number" :disabled="stranka.deleted_at !== null"></li>
        </ul>
      </div>
    <div class="credentials">
      <h3>POSTA</h3>
      <ul>
        <li><input v-model="stranka.postOffice.postal_code" :disabled="stranka.deleted_at !== null"></li>
        <li><input v-model="stranka.postOffice.post_office" :disabled="stranka.deleted_at !== null"></li>
      </ul>
    </div>
      <button @click="updateUserAccount" v-if="stranka.deleted_at === null">
        POSODOBI UPORABNIKA
      </button>
      <button @click="deactivateAccount" v-if="stranka.deleted_at === null">
        DEAKTIVIRAJ UPORABNIKA
      </button>
      <button @click="activateAccount" v-if="stranka.deleted_at !== null">
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
    border: 1px solid white;
    margin-bottom: 1.5rem;
  }
  #stranka button {
    margin-left: 4rem;
  }
</style>