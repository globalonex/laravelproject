<template>
    
    <div>
        <div v-if='products'>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>В корзине</th>
                    <th>Цена</th>
                    <th>Штук</th>
                    <th>Всего</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='product in products' :key='product.id'>
                    <td>{{product.title}}</td>
                    <td>
                        <div>
                            <button  
                            @click='changeProductQuantity(product.product_id, -1)' 
                            :disabled='processing' 
                            class="btn">-</button>
                            В корзине {{product.quantity}}
                            <button 
                            @click='changeProductQuantity(product.product_id, 1)' 
                            :disabled='processing' 
                            class="btn" >+</button>
                        </div>
                    
                    </td>
                    <td>{{product.price}}</td>
                    <td>{{product.quantity}} шт.</td>
                    <td>{{product.quantity * product.price}}</td>
                </tr>
            </tbody>
        </table>
        <button @click='finishOrder' class="btn btn-success">Оформить заказ</button>
        </div>
        <span v-else>
            <em>В корзине отсутствует продукты</em>
        </span>
        


    </div>

</template>
<script>
const Swal = require('sweetalert2')
export default {
    data () {
        return {
            processing: false
                   
        }
    },
    computed: {
        products () {
            return this.$store.state.cartProducts
        }
    },
    methods: {
        finishOrder () {
            axios.get('/order/finish')
            .then(() => {
                    Swal.fire({
                        title: 'Готово',
                        text: 'Заказ успешно оформлен',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
            })
            .catch(() => {
                    Swal.fire({
                        title: 'Произошла ошибка',
                        text: 'Повторите попытку',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
            })
        },
         changeProductQuantity(productId, quantityChange) {
           
            const params = {
                productId,
                quantityChange
            }
            this.$store.dispatch('changeCartProductQuantity', params)

        }
    }
}
</script>
