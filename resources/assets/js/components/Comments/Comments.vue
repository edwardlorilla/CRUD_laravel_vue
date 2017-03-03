<template>
    <div>
        <div class="media" >
            <a class="pull-left" href="#">
                <img class="media-object" style="width:64px" :src="comment.user.photo ? comment.user.photo.file : ''" alt="">
                </a>
            <div class="media-body">
                <h4 class="media-heading">Start Bootstrap
                    <small>August 25, 2014 at 9:30 PM</small>
                    </h4>
                {{comment.body}}
                </div>
            </div>
    </div>
</template>
<style>

</style>
<script>

    export default{
    props: ['comment'],
        data(){
            return{

            }
        },
        components:{

        }
    }
</script>
