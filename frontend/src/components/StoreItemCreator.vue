<template>
  <div id="storeItemCreator">
    <div class="new_field">
      <input v-model="newStoreItem.storeItemData.name" placeholder="ime" type="text">
      <input v-model="newStoreItem.storeItemData.price" placeholder="cena" type="number">
      <input v-model="newStoreItem.storeItemData.description" placeholder="opis" type="text">
      <input type="file" @change="onFileSelected" multiple>
      <button  class="uploadBTN" @click="onUpload">UPLOAD</button>
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
}
.newInfo input{
  text-align: center;
  display: block;
  margin-left: 3rem;
}
.pictureData{

}
.pictureData input{
  color: white;
}
.pictureData button {
  margin-left: 6rem;
  display: block;
}
.uploadBTN {
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
.new_field {
  text-align: center;
  display: block;

  width: 60%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.new_field input {
  padding: 10px;
  margin: 5px;
  text-align: center;
  width: 100%;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.containerCenter{
  display: flex;
  align-items: center;
  justify-content: center;
  align-content: center;
}
</style>