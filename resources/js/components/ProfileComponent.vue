<template>
    <div>
        <div v-for="order in orders" :key="order.id">
            <p>
                <button class="btn"
                :class="buttonClass(order)"
                type="button"
                data-toggle="collapse"
                :data-target="`#collapseExample${order.id}`"
                aria-expanded="false"
                :aria-controls="`collapseExample${order.id}`"
                >Заказ #{{order.id}}</button>
            </p>
            <div class="collapse mb-3" :id="`collapseExample${order.id}`">
                <div class="card card-body">
                    <order-products-component :orderId="order.id"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import OrderProductsComponent from './OrderProductsComponent.vue'

export default {
    props: ['orders'],
    components: {OrderProductsComponent},
    methods: {
        buttonClass(order) {
            return order.status == 0 ? 'btn-primary' : 'btn-success'
        }
    }
}

</script>
