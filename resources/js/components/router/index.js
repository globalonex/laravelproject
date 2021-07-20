import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import store from '../store'

import ProductListComponent from '../ProductListComponent'
import CategoryListComponent from '../CategoryListComponent'
import LoginComponent from '../auth/LoginComponent'
import RegisterComponent from '../auth/RegisterComponent'
import CartComponent from '../CartComponent'
import ProfileComponent from '../ProfileComponent'
import PageNotFoundComponent from '../PageNotFoundComponent'
import CategoriesComponent from '../admin/CategoriesComponent'
import ProductComponent from '../admin/ProductsComponent'

const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

// 2. Определяем несколько маршрутов
// Каждый маршрут должен указывать на компонент.
// "Компонентом" может быть как конструктор компонента, созданный
// через `Vue.extend()`, так и просто объект с опциями компонента.
// Мы поговорим о вложенных маршрутах позднее.
const routes = [
  { path: '/', component: CategoryListComponent },
  { path: '/login', component: LoginComponent},
  { path: '/cart', component: CartComponent, meta: {userRequired: true}},
  { path: '/profile', component: ProfileComponent},
  { path: '/categories/:categoryId', component: ProductListComponent},
  { path: '/register', component: RegisterComponent},
  { path: '/admin/Categories', component: CategoriesComponent },
  { path: '/admin/products', component: ProductComponent },
  { path: '*', component: PageNotFoundComponent}
  
]

// 3. Создаём экземпляр маршрутизатора и передаём маршруты в опции `routes`
// Вы можете передавать и дополнительные опции, но пока не будем усложнять.
const router = new VueRouter({
  mode: 'history',
  routes // сокращённая запись для `routes: routes`
})

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.userRequired)) {
    if(store.state.user) next()
    else {
      store.dispatch('getUser')
      .then(() => {
         next()
      })
      .catch(() => {
        next('/login')
      })
    }
  }
  else next()
})

export default router