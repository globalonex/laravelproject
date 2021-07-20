<template>
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Регистрация</div>

                <div class="card-body">
                    <div v-for='error, idx in errors' :key="idx">
                        <div class="alert alert-danger" role="alert">
                            {{error[0]}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                        <div class="col-md-6">
                            <input type="name"
                            v-model='login'
                            id="login"
                            class="form-control"
                            name="login"
                            required
                            autocomplete="login"
                            autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                        <div class="col-md-6">
                            <input type="email"
                            v-model='email'
                            id="email"
                            class="form-control"
                            name="email"
                            required
                            autocomplete="email"
                            autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                        <div class="col-md-6">
                            <input type="password"
                            v-model='password'
                            @input='checkPasswordsMatch'
                            id='password'
                            class="form-control"
                            name="password"
                            required
                            autocomplete="password"
                            autofocus                            
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="passwordRepeat" class="col-md-4 col-form-label text-md-right">Повторите пароль</label>

                        <div class="col-md-6">
                            <input type="password"
                            v-model='passwordRepeat'
                            @input='checkPasswordsMatch'
                            id='passwordRepeat'
                            class="form-control"
                            name="passwordRepeat"
                            required
                            autocomplete="password"
                            autofocus                            
                            >
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button 
                            @click='register'
                            :disabled='!passwordmatch' 
                            class="btn btn-primary"
                            >
                                   Зарегистрироваться
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</template>


<script>

export default {
    data () {
        return {
            login: '',
            email: '',
            password: '',
            passwordRepeat: '',
            errors: []
            
        }
    },
    computed: {
        passwordmatch () {
            return this.password == this.passwordRepeat
        }
    },
    methods: {
        checkPasswordsMatch () {
            if(!this.passwordmatch) {
                this.errors = [
                    ['Пароли не совподают']
                    ]
            } else {
                this.errors = []
            }
            if(this.password.length <= 3 || this.passwordRepeat.length <= 3) {
                this.errors = [
                    ['Введите больше трёх символов']
                ]
            } else {
                this.errors = []
            }
        },
        register () {
            this.errors = []
            const params = {
                name: this.login,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordRepeat
            }
            axios.post('/api/auth/register', params)
                .then(({data}) => {
                    this.$store.dispatch('setUser', data)
                    this.$router.push('/')
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
                
        }
    }
}

</script>
