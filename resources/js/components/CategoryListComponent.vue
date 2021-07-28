<template>
    <div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="img/header_logo.jpg" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="img/header_logo1.jpg" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="img/header_logo2.jpg" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
        </div>
        <template v-if='loading'>
                <div v-if='loading' class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        </template>
        <template v-else>
            <div class="row">
            <category-component
            class="mt-5 col-md-4"
            v-for='category in categories'
            :category="category"
            :key='category.id'
            >
            </category-component>
            </div>
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
