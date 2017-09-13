<template>
    <div>

        <div v-for="blog in filteredData">
            <h2>
                <router-link  :to="{ name: 'blogPost', params: { id: blog.id }}">{{blog.title}}</router-link>
            </h2>
            <p class="lead">
                by <a href="index.php">{{blog.user ? blog.user.name : ''}}</a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on {{blog.created_at}}</p>
            <hr>
            <img class="img-responsive" :src="blog.photo ? blog.photo.file : '' " alt="">
            <hr>
            <p>{{blog.body}}</p>
            <router-link class="btn btn-primary" :to="{ name: 'blogPost', params: { id: blog.id }}">Read More</router-link>

            <hr>
        </div>
    </div>
</template>
<style>

</style>
<script>

    export default{
        props: {
            data: Array,
            columns: Array,
            filterKey: String,
        },
        data(){
            var sortOrders = {}
            this.columns.forEach(function (key) {
            sortOrders[key] = 1
            })
            return{
                categories: [],
                sortKey: '',
                sortOrders: sortOrders

            }
        },

        computed: {

        filteredData: function () {

        var sortKey = this.sortKey
        var filterKey = this.filterKey && this.filterKey.toLowerCase()
        var order = this.sortOrders[sortKey] || 1
        var data = this.data
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
        }
        }
    }
</script>
