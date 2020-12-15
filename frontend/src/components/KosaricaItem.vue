<template>
<div id="kosaricaItem">

  <div class="item">
    <div class="item_info">
      <h3>IME</h3>
      <p>{{shoppingCartItem.id}} - {{shoppingCartItem.name}}</p>
    </div>

    <div class="item_info">
      <h3>KOLICINA</h3>
      <p>{{shoppingCartItem.pivot.quantity}}</p>
    </div>

    <button @click="increment">+1</button>
    <button @click="decrement">-1</button>
    <br>
    TRENUTNA CENA:
    {{shoppingCartItem.pivot.quantity}} x {{shoppingCartItem.price}} = {{calculatePrice()}}
  </div>

</div>
</template>

<script>
export default {
  name: "KosaricaItem",
  props: ['shoppingCartItem'],
  data: function () {
    return {
      calculatedPrice: 0
    }
  },
  computed: function () {
    return {

    }
  },
  methods: {
    increment() {
      const obj = {
        id: this.shoppingCartItem.id,
        quantity: 1
      }
      this.$store.dispatch('updateShoppingCart', obj);
    },
    decrement() {
      const obj = {
        id: this.shoppingCartItem.id,
        quantity: -1
      }
      this.$store.dispatch('updateShoppingCart', obj);
    },
    calculatePrice() {
      const price = this.shoppingCartItem.pivot.quantity * this.shoppingCartItem.price;
      this.calculatedPrice = price
      return price;
    }
  }
}
</script>

<style scoped>
  #kosaricaItem {
    color: white;
    border: 1px solid white;
    margin-top:2rem;
  }
</style>