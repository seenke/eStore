<template>
<div id="trgovina">
  <StoreItem class="storeItem"
      v-for="storeItem in storeItems" :key=storeItem.id
      :store-item-data=storeItem></StoreItem>
</div>
</template>

<script>
import ApiService from "@/services/service";
import StoreItem from "@/components/StoreItem";
export default {
  name: "Trgovina",
  components: {StoreItem},
  methods: {

  },
  data: function () {
    return {
      authToken: this.$store.getters.authToken,
      storeItems: []
    }
  },
  beforeMount() {
    const apiService = new ApiService(this.$store.getters.authToken);
    console.log("Sending request with token: " + this.$store.getters.authToken)
    apiService.getStoreItems()
    .then((response) => {
      this.storeItems = response
    })
    .catch((err) => {
      console.log(err);
    })

    this.$store.dispatch('getShoppingCart')
    .then(()=> {
      console.log(this.$store.getters.shoppingCartStatus + " status")
    });
  }
}
</script>

<style scoped>
.storeItem{
  margin-top: 2rem;
  margin-left: 9rem;
  margin-right:9rem ;
  display: inline-block;
}
</style>