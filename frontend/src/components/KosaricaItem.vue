<template>
  <div id="kosaricaItem">
    <div class="container">
      <div class="item">
        <div class="item_info">
          <h2 class="itemID">ID: {{shoppingCartItem.id}}</h2>
        </div>

        <div class="item_info">
          <h3>IME: <mark class="green">{{shoppingCartItem.name}}</mark></h3>
        </div>

        <div class="item_info">
          <h3>KOLICINA: <mark class="green">{{shoppingCartItem.pivot.quantity}}</mark></h3>
        </div>
        <button class="buttonDec" @click="decrement">-1</button>
        <button class="buttonInc" @click="increment">+1</button>

        <br>
        <h3> CENA: <mark class="green">{{calculatePrice()}}€ </mark></h3>
      </div>
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
  margin-top:2rem;
}

.container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.buttonDec {
  width: 30px;
  margin: 0 auto;
  padding: 0.3rem 0rem;
  margin-right: 2px;
  background: #BD0000;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.buttonInc {
  width: 30px;
  margin: 0 auto;
  padding: 0.3rem 0rem;
  margin-left: 2px;
  margin-bottom: 10px;
  background: #6cb33e;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.item{
  border-radius: 25px;
  padding-top: 20px;
  padding-bottom: 20px;
  width: 350px;
  height: 160px;
  align: center;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
}

mark.green {
  color:#6cb33e;
  background: none;
}

.itemID {
  font-size: 1rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  color: white;
  opacity: 0.3;
}
</style>