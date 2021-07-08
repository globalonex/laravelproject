import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import ProductListComponent from '../ProductListComponent'
import CategoryListComponent from '../CategoryListComponent'
import LoginComponent from '../auth/LoginComponent'

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
  { path: '/categories/:categoryId', component: ProductListComponent}
]

// 3. Создаём экземпляр маршрутизатора и передаём маршруты в опции `routes`
// Вы можете передавать и дополнительные опции, но пока не будем усложнять.
const router = new VueRouter({
  mode: 'history',
  routes // сокращённая запись для `routes: routes`
})

export default router