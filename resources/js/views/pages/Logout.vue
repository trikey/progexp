<template>
  <div></div>
</template>
<script>
export default {
  mounted() {
    this.$store.dispatch('auth/logout').then(this.redirect);
  },
  methods: {
    redirect() {
      if (this.$route.query.redirect) {
        this.$router.push({ to: this.$route.query.redirect });
      }
      else {
        this.$router.push({ name: 'index' });
      }
    },
  },
};
</script>
