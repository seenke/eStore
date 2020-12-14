<template>
  <div id="app">
    <h1>Kosarica</h1>
    <div v-for="storeItem in JSON.parse(this.$store.getters.shoppingCart)" :key="storeItem.id">
      <p>IME IN ID : {{storeItem.id}} - {{storeItem.name}}</p>
      <p>KOLICINA : {{storeItem.pivot.quantity}}</p>
    </div>
    <button v-on:click="this.emptyShoppingCart">IZPRAZNI KOSARICO</button>
  </div>
</template>

<script>
export default {
  name: "Kosarica",
  methods: {
    emptyShoppingCart() {
      this.$confirm("Ste prepricani da zelite izprazniti kosarico ? Vrnitev na predhodno stanje ne bo mogoca")
          .then(() => {
        this.$store.dispatch('emptyShoppingCart');
      })
      .catch(() => {
        return null;
      })
    }
  }
}
</script>

<style scoped>
  p {
    color: white;
  }
  #app {
    text-align: center;
  }
</style>