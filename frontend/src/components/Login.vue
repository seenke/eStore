<template>
  <div class="card" id="login_card">
    <div class="login_info" id="login_info">
      <h1 id="login">PRIJAVA</h1>

      <h1 id="email">Email</h1>
        <div class="login_field">
          <input type="text" placeholder="Vaš email" name="email" required
                 v-model="userCredentials.email">
        </div>

        <h1 id="password">Geslo</h1>
          <div class="login_field">
            <input type="password" placeholder="Vaše geslo" name="geslo" required
                   v-model="userCredentials.password">
          </div>

          <div class="login_button" id="login_submit">
            <button type="submit" @click="loginUser">Prijava</button>
          </div>
      <p class="loginRedirectText">Nimate uporabniskega racuna ?</p>
      <div class="login_button" style="padding: 15px;">
        <button type="submit"  style="background: none"><router-link to="/registracija" class="loginRedirect">Registracija</router-link></button>
      </div>
      <p class="loginRedirectText">Potrdite ze kreiran uporabniski racun</p>
      <div class="login_button" style="padding: 15px" @click="potrdiRacun">
        <button type="submit" style="background: none">Potrdi racun</button>
      </div>
    </div>
  </div>
</template>

<script>
import ApiService from "@/services/service";

export default {
  name: "Login",
  data: function () {
    return {
      userCredentials: {
        "email": '',
        "password": ''
      }
    }
  },
  methods: {
    registerUser: function () {
      let apiService = new ApiService();
      apiService.loginUser(this.userCredentials)
        .then((response)=> {
          console.log(response);
        })
        .catch((error) => {
          this.$alert(error.response.data.error, 'Napaka', 'error');
        });
    },
    potrdiRacun: function () {
      let apiService = new ApiService();
      this.$prompt("Vnesite email").then((email) => {
        this.$prompt("Vnesite kodo, ki ste jo dobili na: " + email).then((code) => {
          apiService.confirmAccount({
            "email":email,
            "confirmation_code":code
          })
          .then((response) => {
            this.$alert("Uspesno ste potrdili uporabniski racun: " + response.data , "Potrditev uporabniskega racuna", "success");
          })
          .catch((error) => {
            this.$alert("Potrditev uporabniskega racuna je spodletela: " + error.response.data.error, "Potrditev uporabniskega racuna", "error");
          })
        })
      })
    },
    loginUser: function () {
      // let apiService = new ApiService();
      // apiService.loginUser(this.userCredentials)
      // .then((response) => {
      //   console.log(response);
      // })
      // .catch((error) => {
      //   this.$alert("Prijava je spodletela: " + error.response.data.error, "Prijava v uporabniski racun", "error");
      // })
      this.$store.dispatch('login', this.userCredentials)
      .then(()=> this.$router.push('/'))
      .catch((error) => {
        this.$alert("Prijava je spodletela: " + error.response.data.error, "Prijava v uporabniski racun", "error");
      })
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
  margin-top: 1.5rem;
  color: white;
  text-align: center;
}
.card {
  transform-style: preserve-3d;
  height: 40rem;
  width: 20rem;
  border-radius: 25px;
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1), 0px 0px 50px rgba(0, 0, 0, 0.1);
  background: rgba(0, 0, 0, 0.3);
  transition: all 0.5s ease-out;
}

.login_info {
  height: 25rem;
  width: 20rem;
}

.login_info h1 {
  padding-top: 50px;
  font-size: 2rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  font-size: 21px;
  color: white;
}

.login_info h2 {
  padding-top: 20px;
  font-size: 1.3rem;
  text-align: center;
  transition: all 0.5s ease-out;
  text-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
  color: #ffffff;
}

.login_field {
  display: flex;
  width: 60%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.login_field input {
  padding: 10px;
  text-align: center;
  width: 100%;
  border-radius: 30px;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  height: 30px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.login_field input:focus {
  color: #ffffff;
}

.login_button {
  padding-top: 50px;
  display: flex;
  width: 80%;
  margin: 0 auto;
  align-items: center;
  transition: all 0.5s ease-out;
}

.login_button button {
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
</style>