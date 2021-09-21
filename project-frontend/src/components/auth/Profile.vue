<template>
  <div>
    <h1>{{user.name}}</h1>
    <h2>{{user.email}}</h2>
  </div>
</template>

<script>
export default {
  computed: {
    user() {
      return JSON.parse(localStorage.getItem('user'));
    }
  },
}
</script>

<style scoped>

</style>
