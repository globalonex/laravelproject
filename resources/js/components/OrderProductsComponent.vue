<template>
    <div>
        <table class="table bordered">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Итого</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='product in products' :key='product.id'>
                    <td>{{product.title}}</td>
                    <td>{{product.pivot.quantity}}</td>
                    <td>{{product.pivot.price}}</td>
                    <td>{{product.pivot.price * product.pivot.quantity}}</td>
                </tr>
            </tbody>
        </table>
    Общая стоимость заказа: {{orderSum}} руб.
    </div>
</template>

<script>

export default {
    props: ['orderId'],
    data () {
        return {
            products: []
        }
    },
    computed: {
        orderSum() {
            return this.products.reduce((sum, product) => {
                return sum += product.pivot.price * product.pivot.quantity;
            }, 0)
        }
    },
    mounted () {
        axios.get(`/api/order/${this.orderId}/products`)
        .then(({data}) => {
            this.products = data
            console.log(data)
        })
    }
}

</script>
