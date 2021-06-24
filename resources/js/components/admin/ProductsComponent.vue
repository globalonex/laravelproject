<template>
    <div class="container mt-5">
        <h1>Список продуктов</h1>

        <div class="form-group">
            <input v-model='productName' class="form-control" placeholder="Имя нового продукта">
        </div>

        <div class="form-group">
            <textarea v-model='description' rows="5" class="form-control" placeholder="Описание товара">
            </textarea>
        </div>

        <div class="form-group">
            <input v-model='price' class="form-control" placeholder="Цена">
        </div>

        <div class="form-group">
            <input @change='getPicture' class="form-control" type="file">
        </div>

        <div class="form-group">
            <select v-model='categoryId' class="form-control">
                <option
                    v-for='category in categories'
                    :key='category.id'
                    :value='category.id'
                >
                {{category.title}}
                </option>
            </select>
        </div>

        <img v-if='processing' width="30" src='img/loading.gif'>
        <button v-else @click='createNewProduct' class="btn btn-success">
            <span >Сохранить</span>
        </button>

        <img v-if='loading' width="30" src='img/loading.gif'>
        <ul v-else>
            <li v-for='product in products' :key='product.id'>
                {{product.title}}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                products: [],
                categories: [],
                categoryId: null,
                picture: [],
                description: null,
                price: null,
                loading: true,
                processing: false,
                productName: null
            }
        },
        methods: {
            getPicture (e) {
                this.picture = e.target.files[0]
            },
            getCategories () {
                axios.get('/admin/categories/get')
                .then(({data}) => {
                    this.categories = data
                })
            },
            getProducts () {
                axios.get('/products/get')
                .then(({data}) => {
                    this.products = data
                })
                .finally(() => {
                    this.loading = false
                })
            },
            createNewProduct () {
                this.processing = true
                let fData = new FormData
                fData.append('name', this.productName)
                fData.append('picture', this.picture)
                fData.append('description', this.description)
                fData.append('price', this.price)
                fData.append('categoryId', this.categoryId)
                axios.post('/admin/products/create', fData)
                .then(() => {
                    //document.location.reload();
                })
                .finally(() => {
                    this.processing = false
                })
            }
        },
        mounted () {
            this.getCategories()
            this.getProducts()
        }
    }
</script>