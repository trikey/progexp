import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import VueResourceCaseConverter from 'vue-resource-case-converter';

Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueResourceCaseConverter);

/*
может пригодится если захотим подключить кучу вещей, которые юзаются на каждой странице
const requireAll = require.context('_shared/filters', false, /.js$/);
requireAll.keys().forEach(requireAll);
 */

try {
  window.$ = window.jQuery = require('jquery');
}
catch (e) {
  console.log(e);
}

/**
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  Vue.http.headers.common['X-CSRF-TOKEN'] = token.content;
}
else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
