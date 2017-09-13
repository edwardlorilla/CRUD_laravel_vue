<template>
    <div>

        <h4>Blog Search</h4>
        <div class="input-group">
            <input v-model="keyword" class="form-control" placeholder="Search..."
                   @input="onInput($event.target.value)" @keyup.esc="isOpen = false" @blur="isOpen = false"
                   @keydown.down="moveDown" @keydown.up="moveUp" @keydown.enter="select">

            <span class="input-group-btn">
        <button class="btn btn-default" type="button">
        <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>

        </div>
        <ul v-show="isOpen" class=" list-group options-list">
            <li v-for="(option, index) in fOptions" :class="{'highlighted': index === highlightedPosition, 'list-group-item' : true}" @mouseenter="highlightedPosition = index" @mousedown="select">
                <slot name="item" :title="option.title" :description="option.body" :thumbnail="option.photo ? option.photo.file : '/images/default-profile.png' " />

            </li>
        </ul>

        <!--<div class="autocomplete-input">-->
            <!--<p class="control has-icon has-icon-right">-->
                <!--<input v-model="keyword" class="input is-large" placeholder="Search..."-->
                       <!--@input="onInput($event.target.value)" @keyup.esc="isOpen = false" @blur="isOpen = false"-->
                       <!--@keydown.down="moveDown" @keydown.up="moveUp" @keydown.enter="select">-->
                <!--<i class="fa fa-angle-down"></i>-->
            <!--</p>-->
            <!--<ul v-show="isOpen" class="options-list">-->
                <!--<li v-for="(option, index) in fOptions" :class="{-->
               <!--'highlighted': index === highlightedPosition-->
               <!--}" @mouseenter="highlightedPosition = index" @mousedown="select">-->
                    <!--<slot name="item" :title="option.name" :description="option.body" :thumbnail="option.thumbnail"/>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</div>-->
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
     margin-top: 10px;
     border: 1px solid #dbdbdb;
     border-radius: 0 0 0px 0px;
     position: absolute;
     width: 100%;
     overflow: hidden;
     }

     ul.options-list li {
     width: 90%;
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
               }
           },
        data(){
            return{
              isOpen: false,
              highlightedPosition: 0,
              keyword: ''
            }
        },
        computed: {
            fOptions() {
                const re = new RegExp(this.keyword, 'i')
                return this.options.filter(o => o.title.match(re))
            }
        },
        methods: {
        onInput(value) {
        this.highlightedPosition = 0
        this.isOpen = !!value
        },
        moveDown() {
        if (!this.isOpen) {
        return
        }
        this.highlightedPosition =
        (this.highlightedPosition + 1) % this.fOptions.length
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
        this.keyword = selectedOption.title
        }
        }
    }

</script>
