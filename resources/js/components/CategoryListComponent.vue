<template>
    <div>
        <category-component
            v-for='category in categories'
            :category="category"
            :key='category.id'
        >
        </category-component>
    </div>
</template>

<script>
    import CategoryComponent from './CategoryComponent.vue';

export default {
    props: ['categories'],
    components: {CategoryComponent},
    mounted () {

    }
}
</script>
