<template>
    <div>
        <div class="row">
        <!-- Blog Post Content Column -->
            <div class="col-md-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>{{blogpost.title}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">{{blogpost.user ? blogpost.user.name : ''}}</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{blogpost.created_at}}</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" :src="blogpost.photo ? blogpost.photo.file : '' " alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">{{blogpost.body}}</p>


                <hr>
                <!-- Blog Comments -->
                <comment-form :AuthenticatedUser="AuthenticatedUser"  @addedComment="addComment"></comment-form>
                <posted-comments v-for="comment in blogpost.comments" :comment="comment" ></posted-comments>

            </div>

            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

            </div>
            </div>
    </div>
</template>
<style>

</style>
<script>
    import CommentForm from './../Comments/CommentsForm.vue';
    import PostedComments from './../Comments/Comments.vue';
    export default{
        data(){
            return{
                msg:'hello vue',
                blogpost:{


                },
                user:{},
                authUserId:null,
                filters: {
                    notDone: function(todo) {
                        return ! todo.completed;
                    }
                }
            }
        },
        created(){
            this.fetchBlogPost(this.$route.params.id)
            this.fetchUser();
        },

        computed:{
            AuthenticatedUser(){
                return this.$auth.getAuthenticatedUser()
            }
        },
        methods:{
            fetchUser(){
                let id = this.AuthenticatedUser.id
                if(_.isEmpty(id)){
                console.log(0)
                    this.fetchAuthUserId()
                }
                else{
                console.log(1)
                    this.AuthenticatedUsers(id)
                }
            },
            AuthenticatedUsers(id){
            console.log(id )
                this.$http.get('api/users/'+ id).then(response => {
                        return this.user =  response.data.users;
                    }, (response) => {
                    console.log(response)
                    });
            },
            fetchAuthUserId(){
            console.log(3)
                this.$http.get('api/user').then(response => {
                    this.$auth.setAuthenticatedUser(response.body)
                    this.authUserId = this.$auth.getAuthenticatedUser().id
                })

            },
            fetchBlogPost(id){
                this.$http.get('api/blog/' + id).then(response => {
                this.blogpost = response.data.post;
            })
            },
            addComment(comment){
            if (this.authUserId){
                    console.log(5)
                    this.AuthenticatedUsers(this.authUserId)
                }
            let posted_comments = {id: 3,post_id:this.$route.params.id,body:comment, user_id:this.authUserId,user:{photo: {file: this.user.photo ? this.user.photo.file : ''  }}}
                this.blogpost.comments.push(posted_comments)
                this.$http.post( 'api/comments', posted_comments).then((response) => {
                    this.blogpost.comments.pop()
                     this.blogpost.comments.push(response.body.comments)
                }, (response) => {
                // error callback
                });
            }
        },
        components:{
            CommentForm,
            PostedComments
        }
    }
</script>
