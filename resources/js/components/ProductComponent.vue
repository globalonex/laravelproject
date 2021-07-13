<template>
    <div class="card mb-3" style="max-width: 540px;">

    <div class="row no-gutters">
        <div class="col-md-4">
        <img width="180" :src="`/storage/img/${product.picture}`">
        </div>
        <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title">
                {{product.title}}
            </h5>
            <p class="card-text">
                {{product.description}}
            </p>
            <p class="card-text">
                <small class="text-muted">
                    {{product.price}} руб.
                    <div v-if='productQuantity'>
                        <button  
                        @click='addToOrder(-1)' 
                        :disabled='processing' 
                        class="btn">-</button>
                        В корзине {{productQuantity}}
                        <button 
                        @click='addToOrder(1)' 
                        :disabled='processing' 
                        class="btn" >+</button>
                    </div>
                    <button v-else @click='addToOrder(1)' style="color:white" class="btn btn-info">В корзину</button>
                </small>
                
            </p>
            
            
        </div>
        </div>
    </div>
    </div>
</template>

<script>
const Swal = require('sweetalert2')
export default {
    props: ['product'],
    data () {
        return {
            
            processing: false
        }
    },
    computed: {
        productQuantity() {
                const product = this.orderProducts.find(cartProduct => {
                return cartProduct.product_id == this.product.id
            })
            return product ? product.quantity : null
        },
        orderProducts () {
            return this.$store.state.cartProducts
        }
    },
    methods: {
        addToOrder (quantityChange) {
            const params = {
                productId: this.product.id,
                quantityChange
            }
            this.$store.dispatch('changeCartProductQuantity', params)
        }
    },
    mounted () {
        const product = this.orderProducts.find((orderProduct => {
            return orderProduct.product_id == this.product.id
        }))
        if (product) {
            this.quantity = product.quantity
        }
    }
}
</script>

<style scoped>
</style>