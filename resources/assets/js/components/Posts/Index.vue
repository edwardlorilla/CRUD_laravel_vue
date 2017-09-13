<template>
    <div>
        <router-link :to="{name: 'createPost' }">Create Post</router-link>
        <Alert v-if="alert" v-bind:message="alert" />
        <button class="btn btn-danger" @click="destroyPosts">Destroy</button>

        <button id="show-modal" @click="showModal = true">Show Modal</button>
        <modal v-if="showModal" :checkPost="checkedPosts" @close="showModal = false">
            <!--
              you can use custom content here to overwrite
              default content
            -->
            <h3 slot="header">custom header</h3>
        </modal>

        <table class="table table-striped">
           <thead>
               <tr>
                   <th></th>
                   <th>Title</th>
                   <th>Description</th>
                   <th>Categories</th>
               </tr>
           </thead>
           <tbody>
               <tr v-for="post in posts">
                   <td><input type="checkbox" @click="post.completed = !post.completed" :value = "post.id" v-model = "checkedPosts"></td>
                   <td>{{post.title}}</td>
                   <td>{{post.body}}</td>
                   <td v-for="catalog in post.categories" ><span class="label label-success">{{catalog ? catalog.name : "no Catalog"}}</span></td>
               </tr>
           </tbody>
       </table>
    </div>
</template>
<style>

</style>
<script>
    import Modal from './ModalTemplate.vue';
    export default{

        data(){
            return{
                showModal: false,
                posts:[],
                checkedPosts:[],
                post:{
                    completed:false
                },
                filters: {
                    notDone: function(todo) {
                        return ! todo.completed;
                    },
                    completed: function(todo) {
                        return todo.completed;
                    }
                }
            }
        },
        created(){
           this.fetchPosts();
        },
        methods:{
            fetchPosts(){
                this.$http.get('api/posts').then(response => {
                this.posts = response.data.posts;
            })
            },
            destroyPosts: function () {
                this.posts = this.posts.filter(this.filters.notDone);
                this.$http.post('api/posts/destroy', {id :this.checkedPosts }).then((response) => {
                    this.checkedPosts = []
                }, (response) => {
                    // error callbackp
                });
            }

        },
        components:{
            Modal
        }
    }
</script>
