<template>
  <div id="storeItemCreator">
    <div class="newInfo">
      <input v-model="newStoreItem.storeItemData.name" placeholder="ime" type="text">
      <input v-model="newStoreItem.storeItemData.price" placeholder="cena" type="number">
      <input v-model="newStoreItem.storeItemData.description" placeholder="opis" type="text">
    </div>

    <div class="pictureData">
      <input type="file" @change="onFileSelected" multiple>
      <button @click="onUpload">UPLOAD</button>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "StoreItemCreator",
  data: function () {
    return {
      selectedFiles: null,
      newStoreItem: {
        "storeItemData": {
          "name": '',
          "price": '',
          "description": ''
        },
        "pictureData": []
      }
    }
  },
  methods: {
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
          return await this.$alert('Napaka pri shranjevanju slik na streznik ->' + err.response, 'Napaka', 'error');
        }
      }
      this.newStoreItem.pictureData = imageArray;

      console.log(this.newStoreItem)
      try{
        await apiService.createStoreItem(this.newStoreItem);
        await this.$alert("Uspesno dodan nov izdelek", 'Nov izdelek', 'success');
        this.newStoreItem = {
          "storeItemData": {
            "name": '',
            "price": '',
            "description": ''
          },
          "pictureData": []
        }
      }
      catch (err) {
        await this.$alert('Napaka pri dodajanju novega izdelka na streznik', 'Napaka', 'error');
      }
    }
  }
}
</script>

<style scoped>
  #storeItemCreator{
    border: 1px solid white;
  }
  .newInfo input{
    text-align: center;
    display: block;
    margin-left: 3rem;
  }
  .pictureData input{
    color: white;
  }
  .pictureData button {
    margin-left: 6rem;
    display: block;
  }
</style>