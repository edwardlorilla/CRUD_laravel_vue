<template>
    <div>
        <div class="well">
            <h4>Leave a Comment:<span class="_error" v-if="! content.body">*</span></h4>
            <form role="form" @submit.prevent="addComment" >
                <div class="form-group">
                    <textarea class="form-control" rows="3" v-model="content.body" ></textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>
<style>

</style>
<script>
    import PostedComments from './Comments.vue';
    export default{
     props: ['comments', 'AuthenticatedUser'],
        data(){
            return{

                content:{
                    body:'',
                }
            }
        },
        computed: {
        _errors: function() {
        for (var key in this.content) {
        if (!this.content[key]) return true;
        }
        return false;
        }
        },

        methods:{



            addComment(){
                this.$emit('addedComment', this.content.body)
                this.content.body = ''
            }
        },
        components:{
            "posted-comments":PostedComments
        }
    }
</script>
