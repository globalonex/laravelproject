import { reject } from 'lodash'
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: null,
    loginErrors: []
  },
  actions: {
      getUser({commit}) {
        axios.get('/api/auth/getUser')
        .then(response => {
            commit('setUser', response.data)
        })
      },
    login ({commit}, params) {
        commit('clearLoginErrors')
        axios.get('/api/auth/login', {params})
        .then(response => {

            return new Promise((resolve, reject) => {
                commit('setUser', response.data)
                resolve()
            })

            commit('setUser', response.data)
           
        })
        .catch(error => {
            commit('setLoginErrors', error.response.data.errors)
        })
    },
    logout ({commit}) {
        commit('clearUser')
    }
  },
  mutations: {
    setUser(state, user) {
        state.user = user
    },
    login (state, user) {
        state.user = user
    },
    setLoginErrors (state, errors) {
        state.loginErrors = errors
    },
    clearLoginErrors (state) {
        state.loginErrors = []
    },
    clearUser(state, user) {
        state.user = null
    },
    increment (state) {
      state.count++
    }
  }
})

export default store