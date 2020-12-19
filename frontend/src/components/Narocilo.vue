<template>
  <div id="narocilo">
    <ul>
      <h2>NAROCILO - {{narocilo.order.id}}</h2>
      <li v-for="storeItem in narocilo.storeItems" :key="storeItem.id">
        {{storeItem.name}} - {{storeItem.pivot.quantity}}  x {{storeItem.pivot.primary_price}}
      </li>
      <h3>ODDANO: {{narocilo.order.created_at}} </h3>
    </ul>
    <div v-if="JSON.parse($store.getters.user).role === 'Seller'" class="sellerFunctions">
      <h3>ODDAL: {{narocilo.user.name}} {{narocilo.user.lastname}}</h3>
      <button v-if="narocilo.status.status === 'neobdelano' " @click="positiveClick">
        +
      </button>
      <button v-if="narocilo.status.status === 'neobdelano' || narocilo.status.status === 'potrjeno' " @click="negativeClick">
        -
      </button>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "Narocilo",
  props: ['narocilo'],
  methods: {
    "positiveClick": function () {
      const newState = "potrjeno";
      this.chaneOrderStatus(newState);
    },
    "negativeClick": function () {
      const newState = this.narocilo.status.status === 'neobdelano' ? 'preklicano': 'stornirano';
      this.chaneOrderStatus(newState);
    },
    "chaneOrderStatus": function (newState) {
      const apiService = new ApiService(this.$store.getters.authToken);
      this.$confirm("Ste prepricani da zeliste narocilo potrditi ?", "Narocilo", "info")
          .then(() => {
            const obj = {
              "statusName": newState,
              "orderId": this.narocilo.order.id
            };

            apiService.updateOrder(obj)
                .then(()=> {
                  this.$emit("statusUpdate");
                })
                .catch(() => {
                  this.$alert('Napaka pri posodobitvi narocila', 'Napaka', 'error');
                })

          })
    }
  }
}
</script>

<style scoped>

</style>