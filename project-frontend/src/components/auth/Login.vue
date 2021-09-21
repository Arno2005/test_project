<template>
  <div>
    <input type="text" placeholder="E-Mail" v-model="form.email">
    <input type="text" placeholder="Password" v-model="form.password">
    <b-button class="btn btn-submit" @click="login">Login</b-button>
  </div>
</template>

<script>

export default {
  data() {
    return {
      form: {
        email: null,
        password: null,
      },
      name: "Login"
    }
  },
  methods: {
    login() {
      this.axios.post('/login', this.form)
        .then(res => {
          if (res.status === 200) {
            localStorage.setItem('user', JSON.stringify(res.data.user))
            localStorage.setItem('token', JSON.stringify(res.data.token))
            this.$router.push({name: 'Profile'});
          }
        }).catch(err => {
        if (err.status === 422) {
          let errors = err.data;
          Object.keys(errors).map(error_key => {
            this.errors.add({field: error_key, msg: errors[error_key]})
          })
        }
      });
    },
  }
}
</script>

<style scoped>

</style>
