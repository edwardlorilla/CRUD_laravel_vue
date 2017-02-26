<template>
        <tr>
            <td>
                <input type="text"  class="form-control"
                       v-model="editForm.name" v-if="edit"
                >
                <span v-else>{{category.name}}</span>
            </td>
            <td>
                <button type="button" class="btn btn-info"
                        v-on:click="editCategory" v-if="!edit"
                        >
                    Edit
                </button>
                <button type="button" class="btn btn-default"
                        v-on:click="cancelEdit" v-if="edit"
                        >
                    Cancel
                    </button>
                <button type="button" class="btn btn-primary"
                        v-on:click="updateCategory(category, editForm)" v-if="edit"
                        >
                    update
                    </button>
                <button @click="$emit('delete-category', category)" type="button" class="btn btn-danger">Delete</button>
            </td>
        </tr>
</template>
<style>

</style>
<script>

    export default{
        props: ['category'],

        data(){
            return{
                edit: false,
                editForm :{
                    name:''
                }
            }
        },
        methods: {
        editCategory(){
        this.edit = true;
        this.editForm.name = this.category.name;
        },
        cancelEdit(){
        this.edit = false;
        this.editForm.name = '';
        },
        updateCategory(oldCategory, newCategory){
        this.$http.patch('api/categories/' + oldCategory.id, newCategory).then(response => {
        this.$emit('update-category');
        this.cancelEdit();
        console.log(response.data);
        }, (response) => {
        console.log(response.data);
        });
        }
        }
    }
</script>
