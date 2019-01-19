import VueRouter from 'vue-router';
// import Auth from '_shared/services/Auth';
import _ from 'lodash/fp';
import store from '@store/index.js';

export default function (params) {
  const options = _.extend({
    hashbang: false,
    history: true,
    mode: 'history',
  }, params);

  const router = new VueRouter(options);

  router.beforeEach((to, from, next) => {
    const loggedIn = store.getters['auth/loggedIn'];
    if (to.meta.authRequired && !loggedIn) {
      next({
        name: 'login',
        query: { redirect: to.fullPath },
      });
    }
    else {
      next();
    }
  });

  return router;
}
