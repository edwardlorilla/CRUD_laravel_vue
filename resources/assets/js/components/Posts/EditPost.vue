<template>
    <div v-show="post.title" >
        <h1>Edit Post</h1>
        <form @submit.prevent="updateForm" >
            <div class="form-group">
                <input class="form-control title"  type="text"  name="title" placeholder="title" v-model="post.title"  >
            </div>

            <div class="form-group">
                <input class="form-control body" type="text" name="body" placeholder="body" v-model="post.body">
            </div>

            <multiselect v-model="post.categories" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :hide-selected="true" placeholder="Pick some" label="name" track-by="name"></multiselect>

            <div class="form-group">
                <div v-if="!image">
                    <h2>Select an image</h2>
                    </div>
                <div v-else>
                    <img :src="image"/>
                    <button @click="removeImage">Remove image</button>
                    </div>
                <input name="image" type="file" @change="onFileChange">
                </div>
            <button class="btn btn-primary" type="submit">Edit Post</button>
            </form>
        </div>
</template>
<style>
    img {
        width: 30%;
        margin: auto;
        display: block;
        margin-bottom: 10px;
    }
</style>
<script>
    import Multiselect from 'vue-multiselect'
    export default{
        data(){
            return{
                image:'',
                alert:'',
                post:{
                    title:'',
                    body:'',
                    img:'',
                    categories:[]
                },
                baseUrl:'/',
                options:[]
            }
        },
        created(){
            this.fetchPost(this.$route.params.id)
            this.fetchCategories()
        },
        methods: {

        fetchCategories(){
        this.$http.get('api/categories').then(response => {
            this.options = response.data.categories;
        })
        },


        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
            return;
            this.createImage(files[0]);
        },
        createImage(file) {
        var image = new Image();
        var reader = new FileReader();
        var vm = this;
        reader.onload = (e) => {
        vm.image  = e.target.result;
        this.post.img = e.target.result;
        };
        reader.readAsDataURL(file);
        },
        removeImage: function (e) {
        this.image = '';
        this.post.img = '';
        },
        fetchPost: function(id)
        {
        this.$http.get(this.baseUrl + 'api/posts/'+ id).then(response => {
        this.post =  response.data.posts;
        }, (response) => {
        });
        },
        updateForm :function(){
        this.$http.put(this.baseUrl + 'api/posts/' + this.$route.params.id, this.post).then((response) => {
            this.$router.push({path: this.baseUrl+ 'posts'})
            noty({type:'success', layout:'topRight', text:response.data.message})
        }, (response) => {
        });
        }
        },
        components: {
            Multiselect
          },
    }
</script>
