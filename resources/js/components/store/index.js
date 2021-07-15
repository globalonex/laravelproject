import axios from 'axios'
import { reject } from 'lodash'
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: null,
    loginErrors: [],
    cartProducts: []
  },
  getters: {
    cartProductsQuantity (state) {
      return  state.cartProducts.reduce((sum, cartProduct) => {
        return sum += cartProduct.pivot.quantity
      }, 0)
    }
  },
  actions: {
    changeCartProductQuantity({commit}, params) {
      const method = params.quantityChange > 0 ? 'addProduct' : 'removeProduct'
      axios.post(`/api/order/${method}`, params)
      .then(({data}) => {
        commit('setCartProducts', data)
      })
    },
    getCartProducts({commit}) {
      axios.get('/api/order/cart')
      .then(({data}) => {
        commit('setCartProducts', data)
      })
    },
      getUser({commit}) {
        axios.get('/api/auth/getUser')
        .then(response => {
            commit('setUser', response.data)
        })
      },
    login ({commit, dispatch}, params) {
        commit('clearLoginErrors')
        return new Promise((res => {
        axios.get('/api/auth/login', {params})
        .then(response => {
            if(response.data.user) {
                commit('setUser', response.data.user)
            } else {
              dispatch('getUser')
            }
            res()
        })
        .catch(error => {
            commit('setLoginErrors', error.response.data.errors)
        })
        }))
        
    },
    logout ({commit}) {
        commit('clearUser')
    }
  },
  mutations: {

    setCartProducts(state, products) {
      state.cartProducts = products
    },
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