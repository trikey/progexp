<template>
  <div>
    <p>This is a template</p>
    <router-link to="/login" v-if="!loggedIn">login</router-link>
    <router-link to="/user">user</router-link>
    <router-link to="/logout" v-if="loggedIn">logout</router-link>
    <router-view></router-view>
  </div>
</template>
<script type="text/javascript">
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters('auth', [
      'loggedIn',
    ]),
  },
};
</script>
