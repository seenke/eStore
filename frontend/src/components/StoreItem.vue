<template>
<div id="storeItem">
  <slider animation="fade" id="slider">
    <slider-item id="slider_item"
                 v-for="(picture, index) in storeItemData.pictures"
                 :key="index">
    <img :src="generateLink(picture.image)" style="width: 400px; height: 300px">
    </slider-item>
  </slider>
  <button @click="registerEvent">ADD TO CART</button>
  <div class="info">
    <div class="info_item">
      <h2>{{storeItemData.storeItem.name}}</h2>
    </div>
    <div class="info_item">
      <h3>CENA</h3>
      <p>{{storeItemData.storeItem.price}} $</p>
    </div>
    <div class="info_item">
      <h3>OPIS IZDELKA</h3>
      <p>{{storeItemData.storeItem.description}}</p>
  </div>
</div>
</div>
</template>

<script>
import {Slider, SliderItem} from "vue-easy-slider";

export default {
  components: {
    Slider,
    SliderItem
  },
  name: "StoreItem",
  data: function (){
    return {
    }
  },
  props: ['storeItemData'],
  methods: {
    test() {
      console.log(this.storeItemData);
    },
    registerEvent() {
      console.log("Added to cart item with id: " + this.storeItemData.storeItem.id)
    },
    generateLink(picture) {
      return 'http://127.0.0.1:8001/storage/storeItems/' + picture + ".png";
    }
  },
  beforeMount() {
    console.log(this.storeItemData)
    console.log(this.storeItemData.pictureData)
  }

}
</script>

<style scoped>
#slider {
  border-bottom: 1px solid white;
}
#storeItem{
  border: 1px solid white;
  border-radius: 13px;
  width: 20rem;
}
#slider {
}
button {
  width: 40%;
  margin: 1rem 6rem;
  padding: 0.5rem 0rem;
  background: #6cb33e;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}
.info{
  color: white;
  text-align: center;
}
.info_item{
  margin-top: 1rem;
}
.info_item h3 {
  color: #6cb33e;
  margin-bottom: 0.5rem;
}
#slider_item {

}


</style>