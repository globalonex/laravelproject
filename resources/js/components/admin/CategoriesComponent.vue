<template>
    <div class="container mt-5">
        <h1>{{title}}</h1>

        <div class="form-group">
            <input v-model='categoryName' class="form-control" placeholder="Имя новой категории">
        </div>

        <div class="form-group">
            <textarea v-model='categoryDesc' class="form-control" placeholder="Описание новой категории">
            </textarea>
        </div>

        <img v-if='processing' width="30" src='img/loading.gif'>
        <button v-else @click='createNewCategory' class="btn btn-success">
            <span >Сохранить</span>
        </button>

        <img v-if='loading' width="30" src='img/loading.gif'>
        <ul v-else>
            <li v-for='category in categories' :key='category.id'>
                {{category.title}}
            </li>
        </ul>
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
                categoryDesc: null
            }
        },
        methods: {
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
                this.processing = true
                const params = {
                    name: this.categoryName,
                    desc: this.categoryDesc
                }
                axios.post('/api/admin/categories/create', params)
                .then(() => {
                    document.location.reload();
                })
                .finally(() => {
                    this.processing = false
                })
            }
        },
        mounted () {
            this.getCategories()
        }
    }
</script>