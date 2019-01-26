import Vue from 'vue';
import Root from '@views/Root.vue';
import '@root/bootstrap.js';
import initRouter from '@root/router.js';
import routes from '@root/routes.js';
import store from '@store/index.js';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import 'material-design-icons-iconfont';
import VeeValidate from 'vee-validate';

Vue.use(Vuetify, {
  theme: {
    primary: '#3f51b5',
    secondary: '#b0bec5',
    accent: '#8c9eff',
    error: '#b71c1c',
  },
});
Vue.use(VeeValidate);

Vue.http.interceptors.push((request, next) => {
  if (store.getters['auth/token']) {
    request.headers.set('Authorization', `Bearer ${store.getters['auth/token']}`);
  }
  // request.headers.set('Accept', 'application/json')
  next();
});

const router = initRouter({
  routes,
});

new Vue({
  router,
  VeeValidate,
  store,
  render(h) {
    return h(Root);
  },
}).$mount('#app');
