<template>
  <ul>
    <h1>POZDRAVLJENI V SPLETNI TRGOVINI</h1>
  </ul>
</template>

<script>
import ApiService from '../services/service';

export default {
  name: 'HelloWorld',
  props: {
    msg: String
  },
  data: function () {
    return {
      storeItems: [],
      errorMessage: ''
    }
  },
  beforeCreate() {
    let apiService = new ApiService();
    apiService.getStoreItems()
      .then((data) => {
        console.log(data);
        this.storeItems = data;
      })
      .catch((error) => {
        this.errorMessage = error
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
