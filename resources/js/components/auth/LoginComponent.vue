<template>
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Авторизация</div>

                <div class="card-body">
                    <div v-for='error, idx in errors' :key="idx">
                        <div class="alert alert-danger" role="alert">
                            {{error[0]}}
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
                    <label for="email" class="col-md-4 col-form-label text-md-right">Пароль</label>

                        <div class="col-md-6">
                            <input type="password"
                            v-model='password'
                            id='password'
                            class="form-control"
                            name="password"
                            required
                            autocomplete="password"
                            autofocus                            
                            >
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button @click='login' class="btn btn-primary">
                                   Войти
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
            email: '',
            password: '',
            errors: []
        }
    },
    methods: {
        login () {
            this.errors = []
            const params = {
                email: this.email,
                password: this.password
            }
            this.$store.dispatch('login', params)
            
        }
    }
}

</script>
