<template>
    <div>
        <div v-if='products.length'>
            <product-component
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
    props: ['products', 'ordersProducts'],
    components: {ProductComponent},
    mounted () {

    }
}
</script>
