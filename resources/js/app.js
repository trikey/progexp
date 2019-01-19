import Vue from 'vue';
import Root from '@views/Root.vue';
import '@root/bootstrap.js';
import initRouter from '@root/router.js';
import routes from '@root/routes.js';
import store from '@store/index.js';

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
  store,
  render(h) {
    return h(Root);
  },
}).$mount('#app');
