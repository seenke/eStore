<template>
  <div id="stranke">
    <div id="aktivni" class="stranka_container">
      <h1>AKTIVIRANI UPORABNISKI RACUNI</h1>
      <div v-for="userAccount in userAccounts.activated" :key="userAccount.id">
        <stranka :stranka="userAccount" v-on:updated="getAllUserAccounts"></stranka>
      </div>
    </div>
    <div id="neaktivni" class="stranka_container">
      <h1>DEAKTIVIRANI UPORABNISKI RACUNI</h1>
      <div v-for="userAccount in userAccounts.deactivated" :key="userAccount.id" >
        <stranka :stranka="userAccount" v-on:updated="getAllUserAccounts"></stranka>
      </div>
    </div>
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
      "userAccounts": {}
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
    }
  },
  beforeMount() {
    this.getAllUserAccounts();
  }

}
</script>

<style scoped>
  .stranka_container{
    display: inline-block;
    color: white;
    margin-left: 1rem;
  }
</style>