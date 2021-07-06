<template>
    <div class="card">
        <h5 class="card-header">{{category.title}}</h5>
        <div class="card-body">
            <p class="card-text">
                {{category.description}}
            </p>
            <router-link :to='`/categories/${category.id}`'>Перейти</router-link>
        </div>
    </div>
</template>

<script>

export default {
    props: ['category']
}
</script>

<style scoped>
    .card {
        margin-bottom: 20px;
    }
</style>