<template>
  <div id="zaposlen" class="containerZaposlen">
    <div class="aktivan">
      <h3><mark class="green">OSEBNI PODATKI</mark></h3>
      <ul>
        <li class="zaposlen_field"><input v-model="zaposlen.name" :disabled="zaposlen.deleted_at !== null"></li>
        <li class="zaposlen_field"> <input v-model="zaposlen.lastname" :disabled="zaposlen.deleted_at !== null"></li>
        <li class="zaposlen_field"><input v-model="zaposlen.email" :disabled="zaposlen.deleted_at !== null"></li>
      </ul>
    </div>
    <button class="posodobiUporabnika" @click="updateUserAccount" v-if="zaposlen.deleted_at === null">
      POSODOBI UPORABNIKA
    </button>
    <button class="deaktivirajUporabnika" @click="deactivateAccount" v-if="zaposlen.deleted_at === null">
      DEAKTIVIRAJ UPORABNIKA
    </button>
    <button class="aktivirajUporabnika" @click="activateAccount" v-if="zaposlen.deleted_at !== null">
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
  margin-bottom: 1.5rem;
}
#zaposlen button {
  margin-left: 3rem;
}

.containerZaposlen {
  display: flex;
  align-items: center;
  justify-content: center;
  align-content: center;
}

.zaposlen_field {
  display: flex;
  width: 60%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
  padding: 5px;
}

.zaposlen_field input {
  padding: 10px;
  text-align: center;
  width: 100%;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

mark.green {
  color:#6cb33e;
  background: none;
}

.aktivan{
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

.aktivan h3{
  display: flex;
  align-items: center;
  justify-content: center;
}

.posodobiUporabnika {
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
</style>