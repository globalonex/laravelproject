<template>
    <div>
        <div class="form-group form-check">
            <input v-model='history' type="checkbox" class="form-check-input" id="showHistory">
            <label class="form-check-label" for="showHistory">Показать завершённые</label>
        </div>



        <div v-if='activeOrder'>
            <p>
                <button class="btn"
                :class="buttonClass(activeOrder)"
                type="button"
                data-toggle="collapse"
                :data-target="`#collapseExample${activeOrder.id}`"
                aria-expanded="false"
                :aria-controls="`collapseExample${activeOrder.id}`"
                >Заказ #{{activeOrder.id}}</button>
            </p>
            <div class="collapse mb-3" :id="`collapseExample${activeOrder.id}`">
                <div class="card card-body">
                    <small>Не завершённый</small>
                    <order-products-component :orderId="activeOrder.id"/>
                </div>
            </div>
        </div>

        <template v-if='history'>

        <div v-for="order in finishedOrders" :key="order.id">
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
                    <small>Завершённый</small>
                    <order-products-component :orderId="order.id"/>
                </div>
            </div>
        </div>
        </template>
    </div>
</template>

<script>
import OrderProductsComponent from './OrderProductsComponent.vue'

export default {
    props: ['orders'],
    data () {
        return {
            history: true
        }
    },
    computed: {
        finishedOrders () {
            return this.orders.filter((order) => {
                return order.status == 1
            })
        },
        activeOrder () {
            return this.orders.find((order) =>{
                return order.status == 0
            })
        }
    },
    components: {OrderProductsComponent},
    methods: {
        buttonClass(order) {
            return order.status == 0 ? 'btn-primary' : 'btn-danger'
        }
    }
}

</script>


<style scoped>
    .form-check label{
        cursor: pointer;
    }
</style>