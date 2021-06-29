<template>
    
    <div>
        <div v-if='products.length'>
        <table class="table bordered">
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
    props: ['orderProducts'],
    data () {
        return {
            products: this.orderProducts,
            processing: false
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
            this.processing = true
            const params = {
                productId,
                quantityChange
            }
            axios.post('/order/addProduct', params)
            .then(({data}) => {
                if(data.quantity == 0) {
                    this.products = this.products.filter(product => {
                        return product.id != data.id
                    })
                    console.log(this.products)
                } else {
                    const product = this.products.find(product => {
                        return product.id == data.id
                    })
                    console.log(product)
                    const idx = this.products.indexOf(product)
                    this.products[idx].quantity = data.quantity
                }
            })
            .catch(error => {
                if(error.response.status == 401) {
                    Swal.fire({
                        title: 'Товар не найден',
                        text: 'Авторизуйтесь',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            })
            .finally(() => {
                this.processing = false
            });
        }
    }
}
</script>
