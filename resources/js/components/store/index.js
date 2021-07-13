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
        return sum += cartProduct.quantity
      }, 0)
    }
  },
  actions: {
    changeCartProductQuantity({commit}, params) {
      axios.post('/api/order/addProduct', params)
      .then(({data}) => {
          if(data.quantity == 0) {
            commit('deleteCartProduct', data.id)
          } else {
            commit('setCartProductQuantity', data)

          }
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
        axios.get('/api/auth/login', {params})
        .then(response => {
            if(response.data.user) {
                commit('setUser', response.data)
            } else {
              dispatch('getUser')
            }
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
    setCartProductQuantity (state, data) {
      const product = state.cartProducts.find(product => {
        return product.id == data.id
    })
    const idx = state.cartProducts.indexOf(product)
    if(idx === -1) {
      state.cartProducts.push(data)
    } else {
      state.cartProducts[idx].quantity = data.quantity
    }
    
    },
    deleteCartProduct(state, productId) {
      state.cartProducts = state.cartProducts.filter(product => {
        return product.id != productId
    })
    },
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