import indexPage from '@pages/Index';
import loginPage from '@pages/Login';
import logoutPage from '@pages/Logout';
import userPage from '@pages/User';

export default [
  {
    name: 'index',
    path: '/',
    component: indexPage,
    meta: {
      authRequired: false,
    },
  },
  {
    name: 'login',
    path: '/login',
    component: loginPage,
    meta: {
      authRequired: false,
    },
  },
  {
    name: 'logout',
    path: '/logout',
    component: logoutPage,
    meta: {
      authRequired: true,
    },
  },
  {
    name: 'user',
    path: '/user',
    component: userPage,
    meta: {
      authRequired: true,
    },
  },
];
