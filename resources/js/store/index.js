import Vue from 'vue';
import Vuex, { Store } from 'vuex';
import auth from './auth.js';

Vue.use(Vuex);

export default new Store({
  modules: {
    auth,
  },
  strict: process.env.NODE_ENV !== 'production',
});
