<template>
    <div v-if="posts">
        <div class="list-group">
            <div v-for="post in posts">
                <a id="post" :href="'posts/' + post.id" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h4 class="mb-1">{{ post.tutoring_content }}</h4>
                        <small>{{ post.created_at }}</small>
                    </div>
                    <p class="mb-1">Preferred tutoring time: <strong style="color: #2e19ec;">{{ post.when }}</strong></p>
                    <div class="d-flex w-100 justify-content-between">
                        <small class="mb-1">{{ post.course }}</small>
                        <small>{{ post.username }}</small>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div v-else>
        <div class="card-body">No posts</div>
    </div>
</template>

<script>
    import ExampleComponent from './ExampleComponent'
    
    function Post({id, created_at, updated_at, when, course, tutoring_content, username}) {
        this.id = id;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.when = when;
        this.course = course;
        this.tutoring_content = tutoring_content;
        this.username = username;
    }
    
    export default {
        data() {
            return {
                posts: []
            };
        },
        methods: {
            get() {
                window.axios.get('/api/post/list/0').then((response) => {
                    const data = response.data;
                    data.forEach(post => this.posts.push(new Post(post)));
                });
            },
        },
        components: {
            ExampleComponent
        },
        created() {
            this.get();
        }
    }
</script>

<style scoped>

</style>