<template>
  <div id="app">
    <h1>Kosarica</h1>
    <kosarica-item
        v-for="shoppingCartItem in JSON.parse(this.$store.getters.shoppingCart)"
        :shopping-cart-item=shoppingCartItem
        :key="shoppingCartItem.id">

    </kosarica-item>
    <button v-on:click="this.emptyShoppingCart">IZPRAZNI KOSARICO</button>
    <h2>SKUPNA CENA: {{calculateTotal()}}</h2>
    <button @click="checkout">CHECKOUT</button>
  </div>
</template>

<script>
import KosaricaItem from "@/components/KosaricaItem";

export default {
  name: "Kosarica",
  components:{
    KosaricaItem
  },
  methods: {
    emptyShoppingCart() {
      this.$confirm("Ste prepricani da zelite izprazniti kosarico ? Vrnitev na predhodno stanje ne bo mogoca")
          .then(() => {
        this.$store.dispatch('emptyShoppingCart');
      })
      .catch(() => {
        return null;
      })
    },
    calculateTotal() {
      let totalPrice = 0;
      JSON.parse(this.$store.getters.shoppingCart).forEach((shoppingCartItem)=> {
        totalPrice += shoppingCartItem.price * shoppingCartItem.pivot.quantity;
      })
      return totalPrice;
    },
    checkout() {
      this.$confirm("Ste prepircani da zeliste oddati narocilo v obdelavo ?")
        .then(()=> {
          this.$store.dispatch('placeOrder')
              .then(()=> {
                this.$alert(this.$store.getters.orderStatus, 'Narocilo', 'info');
                this.$store.dispatch('emptyShoppingCart');
              })
              .catch(()=> {
                console.log('Prislo je do napake');
              })
        })
    }
  },
  beforeMount() {
    this.$store.dispatch('getShoppingCart')
        .then(()=> {
          console.log(this.$store.getters.shoppingCartStatus + " status")
        });
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
  h2{
    margin-top:1rem;
    color: white;
  }
</style>