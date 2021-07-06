<template>
    <div>
        <template v-if='loading'>
                <div v-if='loading' class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        </template>
        <template v-else> 
        <category-component
            v-for='category in categories'
            :category="category"
            :key='category.id'
        >
        </category-component>
        </template>
    </div>
</template>

<script>
    import CategoryComponent from './CategoryComponent.vue';

export default {
    
    components: {CategoryComponent},
    data () {
        return {
            categories: [],
            loading: true
        }
    },
    mounted () {
        axios.get('/api/categories/get')
        .then(({data}) => {
            this.categories = data
        })
        .finally(() => {
            this.loading = false
        })
    }
}
</script>
