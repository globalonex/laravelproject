<template>
     <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link to="/">{{appName}}</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Каталог
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <template v-if="user">

                        

                        <li class="nav-item">
                            <router-link class="nav-link" to="/cart">Корзина ({{cartProductsQuantity}})</router-link>
                            
                        </li>
                        



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   {{user.name}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <router-link class="dropdown-item btn btn-link" to="/profile">Личный кабинет</router-link>
                                    
                                    <button @click="logout" class="dropdown-item btn btn-link">Выход</button>
                                    <template v-if='user.admin'>
                                        <router-link class="dropdown-item btn btn-link" to='/admin/categories'>Категории</router-link>
                                        <router-link class="dropdown-item btn btn-link" to='/admin/products'>Продукты</router-link>
                                    </template>
                                </div>
                            </li>
                            </template>
                            <template v-else>
                                                            <li class="nav-item">
                                   <router-link to="/login">Авторизация</router-link>
                                </li>


                                <li class="nav-item">
                                   <router-link to="/register">Регистрация</router-link>
                                </li>
                                </template>
                       
                    </ul>
                </div>
            </div>
        </nav>
</template>

<script>

export default {
    props: ['appName'],
    computed: {
        user() {
            return this.$store.state.user
        },
        cartProductsQuantity() {
            return this.$store.getters.cartProductsQuantity
        }
    },
    methods: {
        logout() {
            axios.post('/api/auth/logout')
            .then(() => {
                this.$store.dispatch('logout')
                this.$router.push('/')
            })
        }
    },
    created () {
        this.$store.dispatch('getUser')
        this.$store.dispatch('getCartProducts')
    }

}

</script>

<style scoped>

    .btn-link {
        color:#00000080;
        text-decoration:none;
    }
    .btn-link:hover {
        color:black;
    }
    .nav-item {
        margin-right: 10px;
    }

</style>