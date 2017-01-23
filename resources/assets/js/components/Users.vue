<template>
    <div>
         <Alert v-if="alert" v-bind:message="alert" />
        <button v-if="users.length > 0" class="btn btn-danger" @click="destroySubmit">Destroy</button>
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Username</th>
                <th>Email</th>
                <th></th><th></th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td><input type="checkbox" @click="user.completed = !user.completed" :value = "user.id" v-model = "checkedNames"></td>
                <td> <img :src="user.photo ? user.photo.file : '/images/default-profile.png' " /></td>
                <td>
                    {{user.name}}
                </td>
                <td>
                    {{user.email}}
                </td>
                <td><router-link class="btn btn-default" v-bind:to="'/user/' + user.id" >View</router-link></td>
                <td><router-link class="btn btn-info" v-bind:to="'/user/' + user.id + '/edit'" >Edit</router-link></td>

            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Alert from './Alert.vue';

    export default{
        data(){
            return{
                users:[],
                alert:'',
                checkedNames: [],
                user:{
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
        computed: {
            finished: function() {
                return this.user.filter(this.filters.completed);
            },
            pending: function() {
                return this.user.filter(this.filters.notDone);
            }
        },
        created(){
            if(this.$route.query.alert){
                this.alert = this.$route.query.alert;
            }
            this.fetchUsers();
        },
        methods:{
            fetchUsers(){
                this.$http.get('api/users').then(response => {
                    this.users = response.data.users;
                })
            },
            destroySubmit: function () {
                this.users = this.users.filter(this.filters.notDone);
                this.$http.post('api/user/destroy', {id :this.checkedNames }).then((response) => {
                }, (response) => {
                // error callbackp
                });
            }
        },
        components:{
        Alert
        }

    }
</script>
