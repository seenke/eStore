<template>
  <div class="storeItemEditor">
    <h2>SLIKE KI JIH ZELITE ODSTRANITI IZBERITE S KLIKOM</h2>
    <div class="main-container">
      <div class="image_container" v-if="storeItem !== null">
        <div class="image_container_text">
        </div>
        <img
            v-for="picture in storeItem.pictures"
            :key="picture.id"
            :src="generateLink(picture.image)"
            style=" width: 450px; height: 300px" class="mainpic"
            @click="pictureClickHandler"
            :id="picture.id"
            v-bind:class="{ deleted: toBeDeleted.includes(picture.id.toString()) }">
      </div>
      <h2>ATRIBUTE KI JIH ZELITE SPREMENITI VNESITE V VNOSNA POLJA</h2>
      <div class="credentials_container" v-if="storeItem !== null">
        <div class="horizontal-center">
          <button @click="addToCart" v-if="$store.getters.userRole === 'customer' ">ADD TO CART</button>
        </div>
        <div class="info">
          <div class="info_item">
            <h3>IME</h3>
            <input class="info_item_input1" v-model="storeItem.storeItem.name" type="text">
          </div>
          <div class="info_item">
            <h3>CENA</h3>
            <input class="info_item_input1" v-model="storeItem.storeItem.price" type="number">
          </div>
          <div class="info_item">
            <h3>OPIS IZDELKA</h3>
            <input class="info_item_input2" v-model="storeItem.storeItem.description" type="text">
          </div>
        </div>
      </div>
      <h2>CE IZDELKU ZELITE DODATI NOVE SLIKE JIH IZBERITE</h2>
      <div class="drop_container">
        <input type="file" @change="onFileSelected" multiple>
      </div>
    </div>
    <button class="updateItem" @click="updateStoreItem">POSODOBI IZDELEK</button>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "StoreItemEditor",
  data: function (){
    return {
      "storeItem": null,
      "toBeDeleted": [],
      "selectedFiles": []
    }
  },
  methods: {
    generateLink(picture) {
      console.log(picture)
      return 'http://127.0.0.1:8000/storage/storeItems/' + picture;
    },
    pictureClickHandler(event){
      const pictureId = (event.target.getAttribute('id'));
      const prevLen = this.toBeDeleted.length;
      this.toBeDeleted =this.toBeDeleted.filter((item) => {
        return item !== pictureId
      });
      if (prevLen === this.toBeDeleted.length) {
        this.toBeDeleted.push(pictureId);
      }
      console.log(this.toBeDeleted)
    },
    "onFileSelected": function (event) {
      console.log("onselected")
      console.log(event.target.files)
      this.selectedFiles = event.target.files;
    },
    "onUpload": async function () {
      const apiService = new ApiService (this.$store.getters.authToken);

      let imageArray = [];
      for (const picture of this.selectedFiles) {
        console.log(picture)
        try {
          const fd = new FormData();
          fd.append('image', picture, picture.name);
          const imageOBJ = await apiService.uploadPicture(fd);
          imageArray.push({
            "id": imageOBJ.id
          })
        }catch (err) {
          console.log(err.data)
          return await this.$alert('Napaka pri shranjevanju slik na streznik', 'Napaka', 'error');
        }
      }

      return imageArray;
    },
    "updateStoreItem": async function () {
      const apiService = new ApiService (this.$store.getters.authToken);
      const uploadedImages = await this.onUpload();
      //Removing all deleted images
      this.storeItem.pictures = this.storeItem.pictures.filter((item)=> {
        return !this.toBeDeleted.includes(item.id.toString())
      })
      uploadedImages.forEach((image)=> {
        this.storeItem.pictures.push(image);
      })
      try{
        console.log(JSON.stringify({
          "pictureData": this.storeItem.pictures,
          "storeItemData": this.storeItem.storeItem
        }))
        await apiService.updateStoreItem({
          "pictureData": this.storeItem.pictures,
          "storeItemData": this.storeItem.storeItem
        });
        await this.$alert('Uspesno posodobljen artikel', 'Posodobitev', 'success');
      }catch(err){
        console.log(err);
        return await this.$alert('Napaka pri posodabljanju artikla', 'Napaka', 'error');
      }
    }
  },
  beforeMount() {
    const apiService = new ApiService(this.$store.getters.authToken);
    apiService.getStoreItem(this.$route.params.id)
        .then((response) => {
          this.storeItem = response;
          console.log(response)
        })
        .catch((err) => {
          console.log(err);
        })
  },
}
</script>

<style scoped>
.updateItem {
  margin-left: 46.5rem;
  margin-top: 4rem;
}
.drop_container{
  margin-left: 40rem;
}
.image_container{
  width: 80rem;
  margin-left:25rem ;
}
.mainpic {
  border-radius: 30px;
  transform: scale(0.9);
  display: inline-block;
}
.storeItemEditor h2 {
  text-align: center;
  margin-bottom: 1rem;
  color: white;
}
.deleted {
  border: 3px solid red;
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

.info_item_input1 {
  padding: 10px;
  margin: 5px;
  text-align: center;
  width: 200px;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);

}

.info_item_input2 {
  padding: 10px;
  margin: 5px;
  text-align: center;
  width: 500px;
  height: 500px;
  min-height: 100px;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);

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