<template>
  <div>
    <input type="text" placeholder="E-Mail" v-model="form.email">
    <input type="text" placeholder="Password" v-model="form.password">
    <input type="text" placeholder="Name" v-model="form.name">
    <b-button class="btn btn-submit" @click="register">Register</b-button>
  </div>
</template>

<script>

export default {
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
      },
      name: "Registration"
    }
  },
  methods: {
    register() {
        this.axios.post('/register', this.form)
          .then(res => {
            if (res.status === 200) {
              console.log(res);
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
