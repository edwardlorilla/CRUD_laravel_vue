<template>
    <div>
        <router-link :to="{ name: 'users' }">Back</router-link>
        <div name="fade" is="transition" class="container" >
            <h2 >{{list.name}}
                <span class="pull-right"><button class="btn btn-danger" @click="deleteUser(list.id)">Delete</button></span>
                </h2>
            </div>
        <ul v-if="list"  class="list-group">
            <li  class="list-group-item"> {{list.email}}</li>
            </ul>
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
    list:''
    }
    },
    methods:{
    fetchTask: function(id)
    {
    this.$http.get('api/users/'+ id).then(function (response) {
    this.list = response.data
    });
    },
    deleteUser: function(id){
    this.$http.post('api/user/destroy', {id :[id] }).then(function (response) {
    this.$router.push({name: 'users', query: {alert: 'User deleted'}})
    });
    }
    },
    created:function(){
    this.fetchTask(this.$route.params.id);
    }
    }
    </script>