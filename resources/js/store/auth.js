/* eslint-disable no-param-reassign */
import Vue from 'vue';

const tokenName = 'token';

export default {
  namespaced: true,

  state: {
    user: {},
    token: localStorage.getItem(tokenName),
    loggedIn: !!localStorage.getItem(tokenName),
  },
  getters: {
    user(state) {
      return state.user;
    },
    token(state) {
      return state.token;
    },
    loggedIn(state) {
      return state.loggedIn;
    },
  },
  mutations: {
    setToken(state, token) {
      localStorage.setItem(tokenName, token);
      state.token = token;
    },
    clearToken(state) {
      localStorage.removeItem(tokenName);
      state.token = null;
    },
    login(state) {
      state.loggedIn = true;
    },
    logout(state) {
      state.loggedIn = false;
    },
  },
  actions: {
    async login({ commit }, { email, password }) {
      const response = await Vue.http.post('/api/auth/login', { email, password });
      const token = response.headers.map.authorization[0];
      commit('setToken', token);
      commit('login');
    },
    async refreshToken(state) {
      const response = await Vue.http.get('/api/auth/refresh', {
        headers: {
          Authorization: `Bearer ${state.getters.token}`,
        },
      });
      const token = response.headers.map.authorization[0];
      state.commit('setToken', token);
    },
    async logout(state) {
      await Vue.http.post('/api/auth/logout', {}, {
        headers: {
          Authorization: `Bearer ${state.getters.token}`,
        },
      });
      state.commit('clearToken');
      state.commit('logout');
    },
    async register(store, { email, password }) {
      const response = await Vue.http.post('/api/auth/register', { email, password });
      return response.body;
    },
  },
};

