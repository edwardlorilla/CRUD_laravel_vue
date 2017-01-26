<template>
    <div>
        <div>
            <div class="autocomplete-input form-group" >
                <p  class="control has-icon has-icon-right">
                    <input  v-model="keyword" class="input form-control" placeholder="Search..." @input="onInput($event.target.value)" @keyup.esc="isOpen = false" @blur="isOpen = false"
                            @keydown.down="moveDown" @keydown.up="moveUp" @keydown.enter="select">
                </p>
                <ul  v-show="isOpen" class="list-group options-list">
                    <li v-for="(option, index) in filteredData" :class="{'highlighted': index === highlightedPosition, 'list-group-item' : true}" @mouseenter="highlightedPosition = index" @mousedown="select">
                        <slot class="" name="item" :title="option.name" :description="option.email" :thumbnail="option.photo ? option.photo.file : '/images/default-profile.png' " />
                    </li>
                </ul>
            </div>
            <button v-if="filteredData.length > 0" class="btn btn-danger" @click="destroySubmit">Destroy</button>
            <table class="table">
                <thead>
                <tr>
                    <th v-for="key in columns"

                        @click="sortBy(key)"
                        :class="{ active: sortKey == key }">
                        {{ key | capitalize }}
                        <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
                           </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in filteredData">
                    <td><slot name="checkedUsers" :completed = "user.completed = !user.completed" :id="user.id" ></slot></td>

                    <td>
                        {{user.name}}
                    </td>
                    <td>
                        {{user.email}}
                    </td>
                    <td> <img width="64px" :src="user.photo ? user.photo.file : '/images/default-profile.png' " /></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style>
    ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

input {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
}

.autocomplete-input {
  position: relative;
}

ul.options-list {
  display: flex;
  flex-direction: column;
  margin-top: -12px;
  border: 1px solid #dbdbdb;
  border-radius: 0 0 3px 3px;
  position: absolute;
  width: 100%;
  overflow: hidden;
}

ul.options-list li {
  width: 100%;
  flex-wrap: wrap;
  background: white;
  margin: 0;
  border-bottom: 1px solid #eee;
  color: #363636;
  padding: 7px;
  cursor: pointer;
}

ul.options-list li.highlighted {
  background: #f8f8f8
}
</style>
<script>
    export default{
        props: {
            options: {
                type: Array,
                required: true
            },
            data: Array,
            columns: Array,
        },
        data(){
        var grid = ['name', 'email','photo']
        var sortOrders = {}
        grid.forEach(function (key) {
            sortOrders[key] = 1
        })
        return{
                sortKey: '',
                sortOrders: sortOrders,
                isOpen: false,
                highlightedPosition: 0,
                keyword: '',
                user:{
                    completed: false
                }

            }
        } ,
        computed: {
        finished: function() {
            return this.user.filter(this.filterss.completed);
        },
        pending: function() {
            return this.user.filter(this.filterss.notDone);
        },

        fOptions() {
            const re = new RegExp(this.keyword, 'i')
            return this.options.filter(o => o.name.match(re))
        },
        filteredData: function () {
            var sortKey = this.sortKey
            var filterKey = this.keyword && this.keyword.toLowerCase()
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
            },
        },
        filters: {
        capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            destroySubmit: function () {
                this.data = this.data.filter(this.filterss.notDone);

                this.$http.post('api/user/destroy', {id : this.checkedNames }).then((response) => {
                }, (response) => {
                // error callbackp
                });


            },
            onInput(value) {
                this.highlightedPosition = 0
                this.isOpen = !!value
            },
            moveDown() {
                if (!this.isOpen) {
                return
            }
                this.highlightedPosition =(this.highlightedPosition + 1) % this.fOptions.length
            },
            moveUp() {
            if (!this.isOpen) {
                return
            }
                this.highlightedPosition = this.highlightedPosition - 1 < 0 ? this.fOptions.length - 1 : this.highlightedPosition - 1
            },
            select() {
                const selectedOption = this.fOptions[this.highlightedPosition]
                this.$emit('select', selectedOption)
                this.isOpen = false
                this.keyword = selectedOption.name
            },
            sortBy: function (key) {
                this.sortKey = key
                this.sortOrders[key] = this.sortOrders[key] * -1
            }
        }
    }
</script>
