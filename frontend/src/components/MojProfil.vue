<template>
  <div id="mojProfil">
    <div class="profileItem">
      <h2>IME: <mark class="green">{{JSON.parse(this.$store.getters.user).name}}</mark></h2>
      <button @click="attributeSelect('name')">POSODOBI IME</button>
    </div>
    <div class="profileItem">
      <h2>PRIIMEK: <mark class="green">{{JSON.parse(this.$store.getters.user).lastname}}</mark></h2>
      <button @click="attributeSelect('lastname')" >POSODOBI PRIIMEK</button>
    </div>
    <div class="profileItem">
      <h2>GESLO:</h2>
      <button @click="attributeSelect('password')">POSODOBI GESLO</button>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";
import Registration from "@/components/Registration";
import 'vue-slider-component/theme/default.css'
export default {
  name: "MojProfil",
  components: {
  },
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
  margin-top: 1rem;
  color: white;
  text-align: center;
  border-radius: 25px;
  padding-top: 20px;
  padding-bottom: 20px;
  width: 350px;
  height: 100px;
  justify-content: center;
  align-content: center;
  align-items: center;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
}
.profileItem h2 {
  margin-bottom: 0.5rem;
}
.profileItem button {

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
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

mark.green {
  color:#6cb33e;
  background: none;
}
</style>