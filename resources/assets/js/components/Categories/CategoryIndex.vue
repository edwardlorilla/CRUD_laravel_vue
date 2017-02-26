<template>
    <div>

        <table class="table table-striped">
            <thead>
                <td>Category</td>
                <td>Action</td>
            </thead>
            <tbody>

                 <Category  v-for='category in categories' v-bind:category="category"
                            @delete-category="deleteCategory"
                            v-on:update-category="fetchCategories"
                 >
                 </Category>
            </tbody>
        </table>

    </div>
</template>
<style>

</style>
<script>
    import Category from './Category.vue';
    export default{
        data(){
            return{
                categories:[]
            }
        },
        created(){
            this.fetchCategories();
        },
        methods:{
            fetchCategories(){
                this.$http.get('api/categories').then(response => {
                this.categories = response.data.categories
                })
            },
            deleteCategory(category){
                this.$http.delete('api/categories/' + category.id).then(response => {
                    let index = this.categories.indexOf(category);
                    this.categories.splice(index, 1);
                    console.log(response.data)
            })
        }
    },
        components:{
            Category
        }
    }
</script>
