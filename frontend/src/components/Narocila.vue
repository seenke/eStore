<template>
  <div id="narocila">
    <div id="neobdelano" class="narocilaContainer">
      <h1 class="narocilaContainer_header">NEOBDELANA</h1>
      <div v-for="narocilo in ordersByStatus.neobdelano"
           class="neobdelano narocilo"
           :key="narocilo.id">
        <ul>
          <h2>NAROCILO - {{narocilo.order.id}}</h2>
          <li v-for="storeItem in narocilo.storeItems" :key="storeItem.id">
            {{storeItem.name}} - {{storeItem.pivot.quantity}}  x {{storeItem.pivot.primary_price}}
          </li>
          <h3>ODDANO: {{narocilo.order.created_at}} </h3>
        </ul>
      </div>
    </div>

    <div id="potrjeno" class="narocilaContainer">
      <h1>POTRJENA</h1>
      <div v-for="narocilo in ordersByStatus.potrjeno"
           class="potrjeno"
           :key="narocilo.id">

      </div>
    </div>

    <div id="preklicano" class="narocilaContainer">
      <h1>PREKLICANA</h1>
      <div v-for="narocilo in ordersByStatus.preklicano"
           class="preklicano"
           :key="narocilo.id">

      </div>
    </div>

    <div id="stornirano" class="narocilaContainer">
      <h1>STORNIRANA</h1>
      <div v-for="narocilo in ordersByStatus.stornirano"
           class="stornirano"
           :key="narocilo.id">

      </div>
    </div>

  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "Narocila",
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
      apiService.getSelfOrders()
        .then((orders) => {
          this.orders = orders;
          this.sortOrders();
        })
        .catch((err) => {
          console.log(err);
          this.$alert('Napaka pri pridobivanju narocil', 'Narocila', 'error');
        })
    },
    "sortOrders": function () {
      const orders = this.orders.orders;
      console.log(orders)
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