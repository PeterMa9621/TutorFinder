<template>
    <div class="row">
        <div class="col-2 my-auto mx-auto">
            <img src="http://127.0.0.1:8000/img/user.png" class="rounded-circle" alt="" width="100%">
        </div>
        <div class="col-10">
            <div class="row justify-content-between">
                <h5>[[ comment.user.name ]]</h5>
                <small>[[ comment.updated_at ]]</small>
            </div>
            <div class="row">
                <div class="form-inline">
                    <div v-for="i in comment.score">
                        <span class="fa fa-star mr-1" style="color: orangered"></span>
                    </div>
                    <div v-for="i in (5 - comment.score)">
                        <span class="fa fa-star mr-1"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <p>[[ comment.content ]]</p>
            </div>
            <div class="row justify-content-between">
                <div></div>
                <a href="#">Reply</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                comment: []
            }
        }
    }
</script>

<style scoped>

</style>