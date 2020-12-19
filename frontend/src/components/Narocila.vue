<template>
  <div id="narocila">
    <div id="neobdelano" class="narocilaContainer">
      <h1 class="narocilaContainer_header">NEOBDELANA</h1>
      <div v-for="narocilo in ordersByStatus.neobdelano"
           class="neobdelano narocilo"
           :key="narocilo.id">
        <ul>
          <Narocilo :narocilo="narocilo"  v-on:statusUpdate="getOrders"> </Narocilo>
        </ul>
      </div>
    </div>

    <div id="potrjeno" class="narocilaContainer">
      <h1 class="narocilaContainer_header">POTRJENA</h1>
      <div v-for="narocilo in ordersByStatus.potrjeno"
           class="potrjeno narocilo"
           :key="narocilo.id">
        <ul>
          <Narocilo :narocilo="narocilo" v-on:statusUpdate="getOrders"> </Narocilo>
        </ul>
      </div>
    </div>

    <div id="preklicano" class="narocilaContainer">
      <h1 class="narocilaContainer_header">PREKLICANA</h1>
      <div v-for="narocilo in ordersByStatus.preklicano"
           class="preklicano narocilo"
           :key="narocilo.id">
        <ul>
          <Narocilo :narocilo="narocilo"  v-on:statusUpdate="getOrders"> </Narocilo>
        </ul>
      </div>
    </div>

    <div id="stornirano" class="narocilaContainer">
      <h1 class="narocilaContainer_header">STORNIRANA</h1>
      <div v-for="narocilo in ordersByStatus.stornirano"
           class="stornirano narocilo"
           :key="narocilo.id">
        <ul>
          <Narocilo :narocilo="narocilo"  v-on:statusUpdate="getOrders"> </Narocilo>
        </ul>
      </div>
    </div>

  </div>
</template>

<script>
import ApiService from "@/services/service";
import Narocilo from "@/components/Narocilo";
export default {
  name: "Narocila",
  components:{
    Narocilo
  },
  data:function (){
    return {
      "orders": [],
      "ordersByStatus": {
        "neobdelano": [],
        "potrjeno": [],
        "preklicano": [],
        "stornirano": []
      }
    }
  },
  methods: {
    "getOrders": function () {
      const apiService = new ApiService(this.$store.getters.authToken);
      let promise;
      console.log("getting new orders");
      if (JSON.parse(this.$store.getters.user).role === 'Seller') {
        promise = apiService.getOrders()
      }
      else {
        promise = apiService.getSelfOrders();
      }
        promise
        .then((orders) => {
          this.orders = orders;
          this.sortOrders();
        })
        .catch((err) => {
          console.log(err.response);
          this.$alert('Napaka pri pridobivanju narocil', 'Narocila', 'error');
        })
    },
    "sortOrders": function () {
      const orders = this.orders.orders;
      console.log(orders)
      this.ordersByStatus = {
        "neobdelano": [],
        "potrjeno": [],
        "preklicano": [],
        "stornirano": []
      }
      orders.forEach((order) => {
        console.log(order.status.status);
        if (order.status.status === 'neobdelano') {
          this.ordersByStatus.neobdelano.push(order);
        }
        if (order.status.status === 'potrjeno') {
          this.ordersByStatus.potrjeno.push(order)
        }
        if(order.status.status === 'preklicano') {
          this.ordersByStatus.preklicano.push(order);
        }
        if(order.status.status === 'stornirano') {
          this.ordersByStatus.stornirano.push(order)
        }
      })
      console.log(this.ordersByStatus)
    }
  },
  beforeMount() {
    this.getOrders();
  }
}
</script>

<style scoped>
  .narocilaContainer{
    height: 100%;
    display: inline-block;
    margin-left: 1.5rem;
  }
  .narocilaContainer ul {
    text-align: center;
  }
  .narocilaContainer ul li {
    list-style: none;
  }
  .narocilo {
    border: 1px solid white;
    color: white;
  }
  .narocilaContainer_header {
    text-align: center;
    color: white;
  }
</style>