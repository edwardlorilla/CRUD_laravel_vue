<template>

    <div v-if="users.length > 0">
       <form v-if="users.length > 0" id="search">
           <input class="input form-control" placeholder="Search" name="query" v-model="filterKey">
       </form>
        <Alert v-if="alert" v-bind:message="alert" />
        <button v-if="users.length > 0" class="btn btn-danger" @click="destroySubmit">Destroy</button>
        <div  v-for="pluckrole in pluckRole">
            <input type="checkbox"  :value="pluckrole" v-model = "roles"  /> {{pluckrole}}
        </div>
        <table v-if="users.length > 0"  class="table table-striped">
            <caption  v-if="users.length > 0" ><h1>Users({{computeUsers}})</h1></caption>
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th v-for="key in grid"
                    @click="sortBy(key)"
                    :class="{ active: sortKey == key }">
                {{ key | capitalize }}
                <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
                </span>
                </th>
                <th>Role</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="user in selectedRole">
                <td><input type="checkbox" @click="user.completed = !user.completed" :value = "user.id" v-model = "checkedNames"></td>
                <td>
                    <img v-if="user.photo" width="50px" class="pull-left img-circle" :src="user.photo ? user.photo.file : '' " />
                    <avatar v-else  :username="user.name"></avatar>
                </td>
                <td v-for="key in grid">{{ user[key] }}</td>
                <th>{{user.role ? user.role.name : 'No Role'}}</th>
                <td><router-link class="btn btn-default" v-bind:to="'/user/' + user.id" >View</router-link></td>
                <td><router-link class="btn btn-info" v-bind:to="'/user/' + user.id + '/edit'" >Edit</router-link></td>

            </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
    import Underscore from 'underscore/underscore.js';
    import Alert from './Alert.vue';
    import Avatar from 'vue-avatar/dist/Avatar.vue';
    export default{
        data(){
            var grid = ['name','email']
            var sortOrders = {}
            grid.forEach(function (key) {
            sortOrders[key] = 1
            })
            return{
                roles: [],
                filterKey : '',
                sortKey: '',
                grid: grid,
                sortOrders: sortOrders,
                isOpen: false,
                highlightedPosition: 0,
                keyword: '',
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
                    },
                    getAdministrator:function(todo){
                        return todo.role ? todo.role.name   : '' ;
                    }
                },

            }
        },
        computed: {
            selectedRole(){
                var selectedRoles;
                var roles = this.roles
                var selectedFilter = _.filter(this.filteredData, function(select){return select.role ? select.role.name ? roles.indexOf(select.role.name)!=-1 : select.role.name  : null } );
                if(_.isEmpty(roles)){
                    selectedRoles=this.filteredData
                }else{
                    selectedRoles = selectedFilter
                }
                return selectedRoles
            },
            pluckRole(){
                var users = this.filteredData
                var map = _.map(users, function(num, key){ return num.role?num.role.name:null });
                var unique = _.uniq(map);
                var pluckFilter = _.filter(unique, function(fil){ return fil == "" ? null : fil  });
                return pluckFilter
            },
            userRole(){
                return this.selectedFilterRole
            },
            computeUsers(){
                return  _.size(this.selectedRole)
            },
            filteredData: function () {
            var sortKey = this.sortKey
            var filterKey = this.filterKey && this.filterKey.toLowerCase()
            var order = this.sortOrders[sortKey] || 1
            var data = this.users
            if (filterKey) {
            data = data.filter(function (row) {
                return Object.keys(row).some(function (key) {
                return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                    })
                })
            }
            if (sortKey) {
                data = data.slice().sort(function (a, b) {
                    a = a[sortKey]
                    b = b[sortKey]
                    return (a === b ? 0 : a > b ? 1 : -1) * order
                })
            }
            return data
            },
            finished: function() {
                return this.user.filter(this.filters.completed);
            },
            pending: function() {
                return this.user.filter(this.filters.notDone);
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        created(){
            if(this.$route.query.alert){
                this.alert = this.$route.query.alert;
            }
            if(_.isEmpty(this.users)){
                this.fetchUsers()
            }

        },
        methods:{

            filterRole(){
                this.users = _.filter(this.filteredData, this.filters.getAdministrator );
            },
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
            },
            sortBy: function (key) {
                this.sortKey = key
                this.sortOrders[key] = this.sortOrders[key] * -1
            }
        },
        components:{
            Alert,Avatar
        }
    }

</script>
