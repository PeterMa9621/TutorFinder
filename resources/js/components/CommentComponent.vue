<template>
    <div>
        <div class="card card-body" v-for="comment in comments">
            <comment-structure :comment="comment"></comment-structure>
            <!-- Replied Comments Below
            <div class="card card-body" v-for="replied_comment in comment.replied_comments">
                <comment-structure></comment-structure>
            </div>
            -->
        </div>
    </div>
</template>

<script>
    import CommentStructureComponent from './CommentStructureComponent'

    export default {
        delimiters: ['[[', ']]'],
        props: ['tutor_id'],
        data() {
            return {
                comments: [],
            }
        },
        components: {
            'comment-structure': CommentStructureComponent
        },
        methods: {
            get_courses() {
                window.axios.get("/api/cantutor/" + this.tutor_id).then((response) => {
                    const data = response.data;
                    data.forEach(course => {this.courses.push(course)});
                });
            },
            get_comments() {
                window.axios.get("/api/tutor_comment/" + this.tutor_id).then((response) => {
                    const data = response.data;
                    console.log(data);
                    data.forEach(comment => {
                        console.log("/api/user/" + comment.user_id);
                        this.get_user_info(comment.user_id, (user_info) => {
                            comment['user'] = user_info;
                            this.comments.push(comment);
                        });
                    });
                });
            },
            add_comment() {
                window.axios.post("{{ route('tutor_comment.store') }}", {
                    "tutor_id": "{{$tutor->id}}",
                    "content": this.new_comment===undefined?"This user only leave star rating.":this.new_comment,
                    "score": this.new_score,
                    "user_id": "{{ Auth::id() }}"
                }).then((response) => {
                    this.get_user_info("{{ Auth::id() }}", (user_info) => {
                        var comment = response.data;
                        comment['user'] = user_info;
                        this.comments.unshift(comment);
                        this.new_comment = undefined;
                    });
                });
            },
            get_user_info(user_id, callback) {
                window.axios.get("/api/user/" + user_id).then((response) => {
                    callback(response.data);
                });
            }
        },
        created(){
            console.log(this.tutor_id);
            //this.get_courses();
            this.get_comments();
        }
    }
</script>

<style scoped>

</style>