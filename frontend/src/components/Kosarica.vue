<template>
  <div id="app">
    <h1>Kosarica</h1>
    <div  v-if="this.$store.getters.shoppingCart !== '[]' ">
    <kosarica-item
        v-for="shoppingCartItem in JSON.parse(this.$store.getters.shoppingCart)"
        :shopping-cart-item=shoppingCartItem
        :key="shoppingCartItem.id">

    </kosarica-item>
    </div>
    <br>
    <button v-on:click="this.emptyShoppingCart" class="buttonClear">IZPRAZNI KOSARICO</button>
    <h2>SKUPNA CENA: <mark class="green">{{calculateTotal()}}€</mark></h2>
    <br>
    <button @click="checkout" class="buttonCheckout" v-if="(this.$store.getters.shoppingCart) !== '[]' ">CHECKOUT</button>
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
      if (this.$store.getters.shoppingCart === '') {
        return 0;
      }
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
body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}
p {
  color: white;
}
#app {
  text-align: center;
}
h2 {
  margin-top:1rem;
  color: white;
}
h1 {
  font-size: 2rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  color: #6cb33e;
}

.buttonClear {
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

mark.green {
  color:#6cb33e;
  background: none;
}

.buttonCheckout {
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