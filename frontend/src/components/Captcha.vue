<template>
  <div class="form">
    <div class="row">
<!--      <div><strong>Change: color / mode (math) / resolve (only text) </strong></div>-->
      <my-captcha :callSuccess="captchaOk" color="#6cb33e" mode="math" resolve="text" class="def"></my-captcha>
    </div>
  </div>
</template>

<script>

import myCaptcha from 'vue-captcha'

export default {
  name: 'statusMessage',
  data () {
    return {
      btndis: true,
      captchaValid: false
    }
  },
  methods: {
    captchaOk () {
      console.log('captcha ok.!')
      this.$emit("ok")
      this.captchaValid = true;
    },
    captchaBtn () {
      this.btndis = false
    },
    clicked () {
      alert('button active.!')
    }
  },
  components: {
    'my-captcha': myCaptcha
  }
}
</script>

<style scope>
.def {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #6cb33e;
}
.def canvas{
  background-color: white;
}
.form {
  margin: 10px;
}
.row {
  margin: 10px;
}
.button {
  margin-top: 5px;
  background-color: #1D9D74;
  border: 1px solid transparent;
  border-radius: 3px;
  border-color: #dbdbdb;
  text-align: center;
  font-size: 1em;
  height: 2.25em;
  line-height: 1.5;
  color: white;
  cursor: pointer;
  padding-bottom: calc(0.375em - 1px);
  padding-left: calc(0.625em - 1px);
  padding-right: calc(0.625em - 1px);
  padding-top: calc(0.375em - 1px);
}
.button[disabled] {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>