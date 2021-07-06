<template>
    <div>
        <div v-if='loading' class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div v-if='products.length'>
            <product-component
            @add-to-order='addToOrder'
            v-for='product in products'
            :product="product"
            :orders-products="ordersProducts"
            :key='product.id'
        />
        
        </div>
        <span v-else>
            <div class="text-center">
                <em>
                В данной категории отсутствуют товары
            </em>
            </div>
            
        </span>
    </div>
</template>

<script>
    import ProductComponent from './ProductComponent.vue';

export default {
    
    components: {ProductComponent},
    data () {
        return {
            loading: true,
            products: [],
            ordersProducts: []
        }
    },
    methods: {
        addToOrder(data) {
            console.log('ProductListComponent: add to order is clicked', data)
        }
    },
    mounted () {
        const categoryId = this.$route.params.categoryId
        axios.get(`/api/categories/${categoryId}/products`)
        .then(({data}) => {
            this.products = data
        }).finally(() => {
            this.loading = false
        })
    }
}
</script>


