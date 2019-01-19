<template>
  <div>
    <form @submit.prevent="login()">
      <input type="text" v-model="email"/>
      <input type="password" v-model="password"/>
      <input type="submit" value="Login"/>
    </form>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';

export default {
  mounted() {
    if (this.loggedIn) {
      this.redirect();
    }
  },
  data() {
    return {
      email: '',
      password: '',
    };
  },
  computed: {
    ...mapGetters('auth', [
      'loggedIn',
    ]),
  },
  methods: {
    login() {
      const { email, password } = this;
      this.$store.dispatch('auth/login', { email, password }).then(this.redirect);
    },
    redirect() {
      if (this.$route.query.redirect) {
        this.$router.push({ path: this.$route.query.redirect });
      }
      else {
        this.$router.push({ name: 'index' });
      }
    },
  },
};
</script>
