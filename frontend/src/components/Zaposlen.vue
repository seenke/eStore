<template>
  <div id="zaposlen">
    <div class="credentials">
      <h3>OSEBNI PODATKI</h3>
      <ul>
        <li><input v-model="zaposlen.name" :disabled="zaposlen.deleted_at !== null"></li>
        <li><input v-model="zaposlen.lastname" :disabled="zaposlen.deleted_at !== null"></li>
        <li><input v-model="zaposlen.email" :disabled="zaposlen.deleted_at !== null"></li>
      </ul>
    </div>
    <button @click="updateUserAccount" v-if="zaposlen.deleted_at === null">
      POSODOBI UPORABNIKA
    </button>
    <button @click="deactivateAccount" v-if="zaposlen.deleted_at === null">
      DEAKTIVIRAJ UPORABNIKA
    </button>
    <button @click="activateAccount" v-if="zaposlen.deleted_at !== null">
      AKTIVIRAJ UPORABNIKA
    </button>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "Zaposlen",
  props: ['zaposlen'],
  methods: {
    "updateSelf": function () {
      console.log(this.zaposlen)
    },
    "updateUserAccount": function () {
      const obj = {
        "id": this.zaposlen.id,
        "name": this.zaposlen.name,
        "lastname": this.zaposlen.lastname,
        "email": this.zaposlen.email
      };
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.updateUserAccount(obj)
        .then((response)=> {
          this.$emit('update');
          console.log(response)
        })
        .catch((err)=> {
          console.log(err.response);
        })
    },
    "deactivateAccount": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.deleteUserAccount(this.zaposlen.id)
      .then((res) => {
        console.log(res)
        this.$emit('update');
      })
      .catch((err)=> {
        console.log(err);
      })
    },
    "activateAccount": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.restoreUserAccount(this.zaposlen.id)
      .then((response)=> {
        this.$emit('update');
        console.log(response);
      })
      .catch((err)=> {
        console.log(err);
      })
    }
  },
  data: function () {
    return {

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
#zaposlen {
  border: 1px solid white;
  margin-bottom: 1.5rem;
}
#zaposlen button {
  margin-left: 3rem;
}
</style>