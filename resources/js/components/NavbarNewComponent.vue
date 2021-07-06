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
                            <a :href="routeCart" class="nav-link">Корзина</a>
                        </li>
                        



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   {{user.name}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a :href="routeProfile" class="btn btn-link">Личный кабинет</a>
                                    <button @click="logout" class="btn btn-link">Выход</button>
                                </div>
                            </li>
                            </template>
                            <template v-else>
                                                            <li class="nav-item">
                                    <a class="nav-link" :href="routeLogin">Авторизация</a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" :href="routeRegister">Регистрация</a>
                                </li>
                                </template>
                       
                    </ul>
                </div>
            </div>
        </nav>
</template>

<script>

export default {
    props: ['appName', 'routeLogin', 'routeRegister', 'routeCart', 'routeLogout', 'routeProfile','user'],
    methods: {
        logout() {
            axios.post(this.routeLogout)
            .then(() => {
                window.location.href = '/'
            })
        }
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

</style>