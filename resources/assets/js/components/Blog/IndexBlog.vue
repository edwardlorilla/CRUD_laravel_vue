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
                     :data="selectedCategory"
                     :columns="blogColumns"
                     :filter-key="searchQuery"
                >
                </blog-post>
            </div>
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well" >
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
                            <ul class="list-unstyled" >
                                <li v-for="pluckCategory in pluckCategories" ><a  :value="pluckCategory" @click="categorySelected(pluckCategory)">{{pluckCategory}}</a>
                                </li>
                                <li><a  @click="categorySelected()">All</a>
                                </li>
                            </ul>
                        </div>
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
import BlogPost from './BlogHome.vue';
    export default{
        data(){
            return{
                categories:'',
                searchQuery: '',
                blogposts:[],
                blogColumns: ['title', 'body'],
            }
        },
        computed:{

            selectedCategory(){
            var selectedRoles;
            var categories = this.categories
            var selectedFilter = _.filter(this.blogposts, function(obj) {
            return _.some(obj.categories, {name: categories});
            });
            if(_.isEmpty(categories)){
            selectedRoles=this.blogposts
            }else{
            selectedRoles = selectedFilter
            }
            return selectedRoles
            },
            pluckCategories(){
            var blog = this.blogposts
            var map = _.map(blog, function(num, key){ return num.categories ?_.map(num.categories, function(categoryNum, categoryKey){return categoryNum.name} ):null });
            var unique = _.uniq(_.flatten(map));
            var pluckFilter = _.filter(unique, function(fil){ return fil == "" ? null : fil  });
            return pluckFilter
            },
        },
        created(){
            this.fetchBlogPost()

        },
        methods:{
            fetchBlogPost(){
                this.$http.get('api/blog').then(response => {
                this.blogposts = response.data.posts;
                })
            },
            categorySelected(pluckCategory  ){
                if(pluckCategory){
                    this.categories = pluckCategory
                }else{
                    this.categories = ''
                }
            }
        },
        components:{
            BlogPost
        }
    }
</script>
