<template>
    <div id="app">

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <router-link v-bind:to="'/'" class="navbar-brand">Laravel Vue</router-link>
                    </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><router-link v-if="isAuth" :to="{ name: 'users' }">Users</router-link></li>
                        <li><router-link v-if="isAuth" :to="{ name: 'create' }">Create</router-link></li>
                        <li><router-link v-if="isAuth" :to="{ path:'/posts'}">Posts</router-link></li>
                        <li><router-link v-if="isAuth" :to="{ name: 'categories' }">Categories</router-link></li>
                    </ul>
                    </div>
                </div>
            </nav>

        <div class="container">
               <transition name="fade">

                       <router-view></router-view>

               </transition>
            </div>
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
                isAuth:null,
                authUser:{}
            }
        },
        created(){
            this.isAuth = this.$auth.isAuthenticated();
            this.setAuthenticatedUser()
        },

        methods:{
            setAuthenticatedUser(){
                this.$http.get('api/user').then(response => {
                    this.$auth.setAuthenticatedUser(response.body)
                    console.log(this.$auth.getAuthenticatedUser())
                    this.authUser = this.$auth.getAuthenticatedUser()
                })
            }
        }

    }
</script>