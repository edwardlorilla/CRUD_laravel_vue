<template>
    <div>
        <h1>Create User</h1>
        <form @submit.prevent="submitForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control title" type="text" name="name" placeholder="Name" v-model="user.name">
            </div>
            <div class="form-group">
                <input class="form-control title" type="text" name="email" placeholder="Email"  v-model="user.email">
            </div>
            <div class="form-group">
                <input class="form-control title" type="password" name="password" placeholder="Password" v-model="user.password">
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
            <button class="btn btn-primary" type="submit">Add User</button>
        </form>
    </div>
</template>
<style>
    img {
        width: 30%;
        margin: auto;
        display:block;
        margin-bottom: 10px;
    }

</style>
<script>
    export default{
        data(){
        return{
        image:'',
        user:{
            name:'',
            email:'',
            password:'',
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
        this.user.img = e.target.result;
        };
        reader.readAsDataURL(file);
        },
        removeImage: function (e) {
        this.image = '';
        this.user.img='';
        },
        submitForm :function(){

        this.$http.post( 'api/users',this.user).then((response) => {
            this.$router.push({path: '/'})
        }, (response) => {
                // error callback
        });
        }
        }
    }

</script>


