<template>
  <div id="storeItem" class="itemForSale">
    <slider animation="fade" id="slider">
      <slider-item id="slider_item"
                   v-for="(picture, index) in storeItemData.pictures"
                   :key="index">
        <img :src="generateLink(picture.image)" style=" width: 450px; height: 300px" class="mainpic">
      </slider-item>
    </slider>
    <div class="horizontal-center">
      <button @click="addToCart" v-if="$store.getters.userRole === 'customer' ">ADD TO CART</button>
    </div>
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
      <div class="info_item">
        <h3>OCENA IZDELKA:</h3>
        <p>{{calculateRating(storeItemData)}}</p>
      </div>

      <h3 class="heading" v-if="$store.getters.userRole === 'customer' ">OCENITE IZDELEK: </h3>
      <div class="info_item rating" v-if="$store.getters.userRole === 'customer' ">
        <vue-slider
            :data="ratingRange"
            :marks="true"
            v-model="rating">
        </vue-slider>
      </div>
      <button style="margin-top: 2rem;" class="horizontal-center" @click="addRating" v-if="$store.getters.userRole === 'customer' "> ODDAJ OCENO</button>
      <router-link :to='generateRouteLink()'>
        <button style="margin-top: 5rem;padding: 1rem" class="horizontal-center" v-if="$store.getters.userRole === 'Seller' ">UREDI ARTIKEL</button>
      </router-link>

    </div>
  </div>
</template>

<script>
import {Slider, SliderItem} from "vue-easy-slider";
import VueSlider from "vue-slider-component";
import ApiService from "@/services/service";
export default {
  components: {
    Slider,
    SliderItem,
    VueSlider
  },
  name: "StoreItem",
  data: function (){
    return {
      "rating": 5,
      "ratingRange" : [1, 2, 3, 4, 5]
    }
  },
  props: ['storeItemData'],
  methods: {
    test() {
      console.log(this.storeItemData);
    },
    calculateRating(storeItemData) {
      let sum = 0;
      storeItemData.ratings.forEach((rating) => {
        sum += rating.rating;
      })
      if (sum === 0) {
        return "Izdelek nima ocene - bodite prvi in oddajte svojo oceno"
      }
      return  sum/storeItemData.ratings.length;
    },
    generateLink(picture) {
      console.log(picture)
      return 'http://127.0.0.1:8000/storage/storeItems/' + picture;
    },
    addToCart() {
      const obj = {
        "id": this.storeItemData.storeItem.id,
        "quantity": 1
      }
      this.$store.dispatch('updateShoppingCart', obj);
    },
    addRating() {
      const apiService = new ApiService(this.$store.getters.authToken);
      apiService.createSelfRating({
        "rating": this.rating,
        "store_item_id": this.storeItemData.storeItem.id
      })
          .then(() =>  {
            this.$alert("Ocena uspesno oddana",'Ocena', 'info');
            this.$forceUpdate();
          })
          .catch((err) => {
            console.log(err)
            this.$alert(err.response.data.error, 'Ocena', 'error');
          })
    },
    generateRouteLink() {
      return "/uredi/" + this.storeItemData.storeItem.id;
    }
  },
  beforeMount() {
    console.log(this.storeItemData.storeItem.id)
    console.log(this.storeItemData.pictureData)

  }

}
</script>

<style scoped>
.mainpic {
  border-radius: 30px;
  transform: scale(0.9);
}

.horizontal-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.itemForSale{
  border-radius: 25px;
  padding-top: 10px;
  padding-bottom: 20px;
  width: 450px;
  height: 770px;
  justify-content: center;
  align-content: center;
  align-items: center;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
}

button {
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
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);}

.info{
  color: white;
  text-align: center;
}

.info_item{
  margin-left: 0.5rem;
  margin-right: 0.5rem;
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.info_item h3 {
  color: #6cb33e;
  margin-bottom: 0.5rem;
}

.rating {
  width: 7rem;
  margin: auto;
}

.heading {
  margin-bottom: 1rem;
  color: #6cb33e;
}
</style>