<template>
    <div>
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <blog-post
                     :data="blogposts"
                     :columns="blogColumns"
                     :filter-key="searchQuery"
                >

                </blog-post>
            </div>
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" v-model="searchQuery" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->

                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>


            </div>
        </div>

    </div>
</template>
<style>
</style>
<script>
import BlogPost from './BlogPost.vue';
    export default{
        data(){
            return{
                searchQuery: '',
                blogposts:[],
                blogColumns: ['title', 'body']

            }
        },

        created(){
            this.fetchBlogPost()

        },
        methods:{
            fetchBlogPost(){
                this.$http.get('api/blog').then(response => {
                this.blogposts = response.data.posts;
                console.log(this.blogposts)
                })
            }
        },
        components:{
            BlogPost
        }
    }
</script>
