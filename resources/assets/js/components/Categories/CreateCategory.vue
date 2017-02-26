<template>
    <div>
        <form @submit.prevent="submitCategory" method="post">
            <div class="form-group">
                <input class="form-control title" type="text" name="name" placeholder="Category" v-model="category.name">
                </div>
            <button class="btn btn-primary" type="submit">Create Category</button>
        </form>
    </div>
</template>

<script>

    export default{
        data(){
            return{
                baseURL:'/',
                category:{
                    name:''
                }
            }
        },
        methods:{
            submitCategory(){
            this.$http.post( this.baseURL + 'api/categories', this.category).then((response) => {
            this.$router.push({path: '/categories'})
            }, (response) => {
            // error callback
            });
            }
        }


    }
</script>
