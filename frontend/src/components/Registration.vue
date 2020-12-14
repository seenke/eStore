<template>
  <div class="card" id="register_card">
    <div class="register_info" id="register_info">
      <h1 id="register">REGISTRACIJA</h1>

      <h1 id="name">Ime in Priimek</h1>
        <div class="register_field">
          <input style="margin-right: 2px" type="text" placeholder="Vaše ime" name="ime" required
                 v-model="userCredentials.accountData.name">
          <input style="margin-left: 2px" type="text" placeholder="Vaš priimek" name="priimek" required
                 v-model="userCredentials.accountData.lastname">
        </div>

        <h1 id="email">Email</h1>
          <div class="register_field">
            <input type="text" placeholder="Vaš email" name="email" required
                   v-model="userCredentials.accountData.email">
          </div>

          <h1 id="password">Geslo</h1>
            <div class="register_field">
              <input type="password" placeholder="Vaše geslo" name="geslo" required
                     v-model="userCredentials.accountData.password">
            </div>

            <h1 id="address">Naslov in hišna številka</h1>
              <div class="register_field">
                <input style="margin-right: 2px; width: 75%" type="text" placeholder="Naslov" name="naslov" required
                       v-model="userCredentials.addressData.street">
                <input style="margin-left: 2px; width: 25%" type="text" placeholder="Št." name="hisna_stevilka" required
                       v-model="userCredentials.addressData.street_number">
              </div>

              <h1 id="Post">Mesto in poštna številka</h1>
                <div class="register_field" id="postOfficeSelect">
                  <select type="text" class="register_field custom-select" v-model="userCredentials.postOfficeData.id">
                    <option  v-for="postOffice in postOffices" :key="postOffice.id" :value="postOffice.id">
                      {{postOffice.post_office}} - {{postOffice.postal_code}}
                    </option>
                  </select>
                </div>

                <div class="register_button" id="register_submit">
                  <button type="submit" v-on:click="registerUser" style="margin-left: 8rem;">Registracija</button>
                  <captcha class="captcha" v-on:ok="validCaptcha=true">
                  </captcha>
                </div>

              <p class="loginRedirectText">Ze imate uporabniski racun ?</p>
              <div class="register_button" style="padding: 15px">
                <button type="submit" style="background: none"><router-link to="/prijava" class="loginRedirect">Prijava</router-link></button>
              </div>
    </div>

  </div>
</template>

<script>
import ApiService from "@/services/service";
import Captcha from "@/components/Captcha";
export default {
  name: "Registration",
  components: {
    'captcha': Captcha
  },
  data: function () {
    return {
      registrationStatus: '',
      postOffices : [],
      error: null,
      userCredentials: {
        "accountData" : {
          "name": '',
          "lastname": '',
          "email": '',
          "password": ''
        },
        "addressData" : {
          "street" : '',
          "street_number" : ''
        },
        "postOfficeData" : {
          "id" : ''
        }
      },
      validCaptcha: false
    }
  },
  beforeCreate() {
    let apiService = new ApiService();
    apiService.getPostOffices()
      .then((data) => {
        this.postOffices = data;
      })
    .catch((error) => {
      this.error = error;
    })
  },
  methods: {
    registerUser: function () {
      const status = this.validateUserData();
      console.log(this.validCaptcha)
      if (status === '') {
        let apiService = new ApiService();
        apiService.registerUser(this.userCredentials)
        .then(() => {
          this.$alert("Uspesna registracija", "Registracija", 'success')
          this.registrationStatus = "Uspesan registracija, prosimo potrdite vas uporabniski racun s kodo, ki smo vam jo poslali na elektronski naslov: " + this.userCredentials.accountData.email
          this.cleanData()
        })
        .catch((err) => {
          this.$alert("Registracija spodletela: " + err, "Registracija", 'error');
        })
      }
      else {
        this.$alert("Registracija spodletela: " + status, "Registracija", 'error');
        return this.registrationStatus = status;
      }

    },
    validateUserData: function () {
      const user = this.userCredentials.accountData;
      if (user.name.length < 3 || !/^[a-zA-Z]+$/.test(user.name)) {
        return "Ime lahko vsebuje le crke in mora biti dolzine vsaj 3 !";
      }
      if(user.lastname < 3 ||  !/^[a-zA-Z]+$/.test(user.name) ) {
        return "Priimek lahko vsebuje le crke in mora biti dolzine vsaj 3 !";
      }
      if (!this.validateMail(user.email)){
        return "Email naslov mora biti veljaven !"
      }
      if (!this.validatePassword(user.password)) {
        return "Geslo mora vsebovati vsaj en poseben znak in vsaj eno stevilko, dolzina pa mora biti vsaj 5";
      }
      const address = this.userCredentials.addressData;
      if (!/^[a-zA-Z]+$/.test(address.street) || !this.isNumeric(address.street_number)) {
        return "Potrebno je vnesti ustrezen naslov";
      }
      const postOffice = this.userCredentials.postOfficeData;
      if (!this.isNumeric(postOffice.id)) {
        console.log(postOffice)
        return "Potrebno je izbrati ustrezno posto";
      }
      if (!this.validCaptcha) {
        return "Overite, da niste robot"
      }
      return '';
    },
    validateMail: function (email) {
      //eslint-disable-next-line
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    },
    validatePassword: function (password) {
      //String has to have at least one number
      //String has at least one special character
      const regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
      return regularExpression.test(password);
    },
    isNumeric : function (string) {
      return  /^\d+$/.test(string);
    },
    cleanData: function () {
      this.userCredentials = {
        "accountData" : {
          "name": '',
          "lastname": '',
          "email": '',
          "password": ''
        },
        "addressData" : {
          "street" : '',
          "street_number" : ''
        },
        "postOfficeData" : {
          "id" : ''
        }
      }
    }
  }
}
</script>

<style scoped>
.loginRedirect{
  text-decoration: none;
  color: white;
  border: none;
  text-underline: none;
}
.loginRedirectText{
  margin-top: 4rem;
  color: white;
  text-align: center;
}
.card {
  transform-style: preserve-3d;
  height: 60rem;
  width: 25rem;
  border-radius: 25px;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
}

#postOfficeSelect {
  width: 25rem;
  border-radius: 12px;
}


.register_info {
  height: 25rem;
  width: 25rem;
}

.register_info h1 {
  padding-top: 50px;
  font-size: 2rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  color: white;
  font-size: 20px;
}

.register_info h2 {
  padding-top: 20px;
  font-size: 1.3rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  color: #ffffff;
}

.register_field {
  display: flex;
  width: 60%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.register_field input {
  padding: 10px;
  text-align: center;
  width: 100%;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.register_field input:focus {
  color: #ffffff;
}

.register_button {
  padding-top: 50px;
  display: flex;
  width: 80%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.register_button button {
  width: 40%;
  margin: 0 auto;
  padding: 0.5rem 0rem;
  background: #6cb33e;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 30px;
  font-weight: bolder;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

#register_submit{
  display: inline-block;
}
.captcha{
  margin-left: 5.5rem;
}
</style>