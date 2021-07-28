<template>
    <div class="container mt-5">
        <h1>Список категорий!</h1>
        <div v-for='error, idx in errors' :key="idx">
            <div class="alert alert-danger" role="alert">
                {{error[0]}}
            </div>
        </div>
       
        <div class="form-group">
            <input v-model='categoryName'
            @input='checkMatch'
            id="catName"
            class="form-control"
            placeholder="Имя новой категории">
        </div>

        <div class="form-group">
            <textarea v-model='categoryDesc'
            @input='checkMatch' 
            id="catDesc"
            class="form-control" 
            placeholder="Описание новой категории">
            </textarea>
        </div>

        <img v-if='processing' width="30" src='img/loading.gif'>
        <button v-else 
        @click='createNewCategory' 
        :disabled='inputmatch'
        class="btn btn-success">
            <span >Сохранить</span>
        </button>

        <img v-if='loading' width="30" src='img/loading.gif'>
        <div v-else style="
        border: 1px gray solid;
        background: white;
        border-radius: 9px;
        "
        class="mt-5"
        >
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='category in categories' :key='category.id'>
                    <td>{{category.id}}</td>
                    <td>{{category.title}}</td>
                    <td>{{category.description}}</td>
                    <td><button class="btn btn-danger" @click="categoryDelete(category.id)">Удалить</button></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
    export default {
          
        props: ['title'],
        data () {
            return {
                categories: [],
                loading: true,
                processing: false,
                categoryName: null,
                categoryDesc: null,
                errors: []
            }
        },
        computed: {
        inputmatch () {
            return this.categoryName === this.categoryDesc
        },
        notempty () {
            return this.categoryName != '' & this.categoryDesc != ''
        }
    },
        methods: {

            checkMatch () {
                
                if(this.inputmatch) {
                    this.errors = [
                        ['Они не должны быть одинаковыми']
                    ]
                } else if (!this.notempty) {
                    this.errors = [
                        ['Заполните все поля']
                    ]
                } else {
                    this.errors = []
                }
            },
            getCategories () {
                axios.get('/api/admin/categories/get')
                .then(({data}) => {
                    this.categories = data
                })
                .finally(() => {
                    this.loading = false
                })
            },
            createNewCategory () {
                this.errors = []
                this.processing = true
                const params = {
                    name: this.categoryName,
                    desc: this.categoryDesc
                }
                axios.post('/api/admin/categories/create', params)
                .then(() => {
                    document.location.reload();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.processing = false
                    
                })
            },
            categoryDelete (id) {
                this.errors = []
                this.processing = true
                axios.post(`/api/admin/categories/deleteCategory/${id}`)
                .then(() => {
                    document.location.reload();
                })
                .catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.processing = false
                })
                    //.then(response => console.log(response))
                    //.catch(error => console.log(error))
                
                
            }
        },
        mounted () {
            this.getCategories()
        }
    }
</script>