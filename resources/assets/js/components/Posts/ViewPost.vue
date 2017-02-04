<template>
    <div>
       <div name="fade" is="transition" class="container" >
            <h2 >
                {{post.title}}
                </h2>
        </div>
        {{post.body}}
    </div>
</template>
<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
<script>

    export default{
        data(){
            return{
                baseUrl: '/',
                post:''
            }
        },
        created:function(){
        this.fetchPost(this.$route.params.id);
        },
        methods:{
            fetchPost(id){
                this.$http.get(this.baseUrl + 'api/posts/' + id).then(response => {
                this.post = response.data.posts;

            })
            }
        },
        components:{

        }
    }
</script>
