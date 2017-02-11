<template>
    <div>
        <h1>Create Post</h1>
        <form @submit.prevent="submitPost" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control title" type="text" name="title" placeholder="Title" v-model="post.title">
            </div>
            <div class="form-group">
                <input class="form-control title" type="text" name="body" placeholder="Description" v-model="post.body">
            </div>

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
            <button class="btn btn-primary" type="submit">Create Post</button>
            </form>
    </div>
</template>
<style>
</style>
<script>

    export default{
        data(){
            return{
                baseURL: '/',
                image:'',
                post:{
                    title:'',
                    body:'',
                    img:''
                }
            }
        },
        methods: {
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
                vm.image = e.target.result;
                this.post.img = e.target.result;
            };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = '';
                this.post.img = '';
            },
            submitPost(){

                this.$http.post( this.baseURL + 'api/posts', this.post).then((response) => {
                this.$router.push({path: '/posts'})
            }, (response) => {
            // error callback
            });
            }
        }
}


</script>
