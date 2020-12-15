<template>
  <div id="mojProfil">
    <div class="profileItem">
      <h2>IME:</h2>
      <h3>{{JSON.parse(this.$store.getters.user).name}}</h3>
      <button @click="attributeSelect('name')">POSODOBI IME</button>
    </div>
    <div class="profileItem">
      <h2>PRIIMEK:</h2>
      <h3>{{JSON.parse(this.$store.getters.user).lastname}}</h3>
      <button @click="attributeSelect('lastname')" >POSODOBI PRIIMEK</button>
    </div>
    <div class="profileItem">
      <h2>GESLO:</h2>
      <h3>********</h3>
      <button @click="attributeSelect('password')">POSODOBI GESLO</button>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";
import Registration from "@/components/Registration";

export default {
  name: "MojProfil",
  methods: {
    "updateAttribute": function (attributeName, newValue) {
      this.user[attributeName] = newValue;
      const apiService = new ApiService(this.$store.getters.authToken);
      console.log(this.user);
      apiService.updateSelf(this.user)
        .then((response) => {
          console.log(response)
          this.$store.dispatch('updateSelf', response);
        })
        .catch((err) => {
          console.log(err.response.data);
          this.$alert('Posodobitev atributa ' + attributeName +" je spodletela", "Posodobitev", "error");
        })
    },
    "attributeSelect": function (attributeName) {
      this.$prompt('Vnesite novo vrednost atributa ' + attributeName)
      .then((attributeValue)=> {
        if(attributeName === 'password' && !Registration.methods.validatePassword(attributeValue)){
         return  this.$alert('Geslo mora biti ustrezne dozline in vsebovati vsaj en poseben znak in veliko crko', 'Geslo', 'error');
        }
        this.updateAttribute(attributeName, attributeValue);
      })
    }
  },
  data: function () {
    return {
      "user": {
        "name": JSON.parse(this.$store.getters.user).name,
        "lastname": JSON.parse(this.$store.getters.user).lastname
      }
    }
  }
}
</script>

<style scoped>
  .profileItem{
    border: 1px solid white;
    border-radius: 13px;
    margin-top: 1rem;
    color: white;
    text-align: center;
  }
  .profileItem h2 {
    margin-bottom: 0.5rem;
  }
  .profileItem button {
    margin: 0.5rem 0rem;
  }
</style>