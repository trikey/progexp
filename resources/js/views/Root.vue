<template>
  <v-app>
    <v-navigation-drawer app temporary v-model="drawer" >
      <v-list>
        <v-list-tile v-for="item in users" :key="item.title" avatar @click="">
          <v-list-tile-action>
            <v-icon v-if="item.icon" color="pink">star</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-avatar>
            <img :src="item.avatar">
          </v-list-tile-avatar>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar app dark color="primary">
      <v-toolbar-side-icon @click="drawer=!drawer"></v-toolbar-side-icon>
      <v-toolbar-title>Title</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down" mr-5>
        <v-btn flat to="/" v-if="loggedIn">
          <v-icon left>home</v-icon>
          Home
        </v-btn>
        <v-btn flat to="/login" v-if="!loggedIn">
          <v-icon left>exit_to_app</v-icon>
          Login
        </v-btn>
        <v-btn flat to="/user" v-if="loggedIn">
          <v-icon left>account_circle</v-icon>
          Profile
        </v-btn>
        <v-btn flat to="/logout" v-if="loggedIn">
          <v-icon left>exit_to_app</v-icon>
          Logout
        </v-btn>
        <v-btn flat to="/registration" v-if="!loggedIn">
          <v-icon left>fingerprint</v-icon>
          Register
        </v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>
<script type="text/javascript">
import { mapGetters } from 'vuex';

export default {
  data(){
    return {
      drawer: false,
      users: [
        { icon: true, title: 'Jason Oner', avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg' },
        { title: 'Travis Howard', avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg' },
        { title: 'Ali Connors', avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg' },
        { title: 'Cindy Baker', avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg' }
      ]
    }
  },
  computed: {
    ...mapGetters('auth', [
      'loggedIn',
    ]),
  },
};
</script>
