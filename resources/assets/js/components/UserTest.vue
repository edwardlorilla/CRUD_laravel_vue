<template>
    <div>
        <autocomplete-input  :options="users"
                             @select="onOptionSelect"
                             :data="users"
                             :columns="gridColumns"
                             :deleteButton="deleteUsers"
        >


            <template slot="item" scope="option">
                <article class="media row">
                    <figure class="col-sm-6 col-md-3 pull-left">
                        <p class="image is-64x64">
                            <img  class="img-thumbnail img-responsive" width="64"  :src="option.thumbnail">
                        </p>
                    </figure>
                    <p>
                        <strong>{{ option.title }}</strong>
                        <br> {{ option.description }}
                    </p>
                </article>
            </template>
           <template slot="checkedUsers" scope="option">
               <input type="checkbox" @click="option.completed" :value = "option.id" v-model = "checkedNames" >
           </template>

        </autocomplete-input>

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

    import AutocompleteInput from './AutoComplete.vue';
    export default{
    data() {
    return {
            gridColumns: ['name', 'email','photo'],
            users: [],
            quantity: 0,
            search: '',
            url : 'api/users',
            suggestions: [],
            suggestionAttribute: 'name',
            selectedEvent: "",
            option:{
                    completed:false
            },
            filterss: {
                notDone: function(todo) {
                    return ! todo.completed;
                },
                completed: function(todo) {
                    return todo.completed;
                }
            },
            checkedNames:[]
        }
    },

    created:function(){
    this.fetchUsers()

    },
    methods:{
    fetchUsers(){
    this.$http.get(this.url).then(function(response){
    this.users = response.data.users;
    })
    },
    onOptionSelect(option) {
    console.log('Selected option:', option)
    }
    },
    components: {
    'autocomplete-input':AutocompleteInput
    }
    }
</script>
