@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Recent Posts</div>
                <template id="home-page-list-view" :posts="posts">
                    <div v-if="posts">
                        <div class="list-group">
                            <div v-for="post in posts">
                                <a id="post" :href="'posts/' + post.id" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h4 class="mb-1">[[ post.tutoring_content ]]</h4>
                                        <small>[[ post.created_at ]]</small>
                                    </div>
                                    <p class="mb-1">Preferred tutoring time: <strong style="color: #2e19ec;">[[ post.when ]]</strong></p>
                                    <div class="d-flex w-100 justify-content-between">
                                        <small class="mb-1">[[ post.course ]]</small>
                                        <small>[[ post.username ]]</small>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div v-else>
                        <div class="card-body">No posts</div>
                    </div>
                </template>

                <button @click="app.get()">Load More</button>

            </div>
        </div>
    </div>
</div>



<script>
    function Post({id, created_at, updated_at, when, course, tutoring_content, username}) {
        this.id = id;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.when = when;
        this.course = course;
        this.tutoring_content = tutoring_content;
        this.username = username;
    }

    var component1 = {
        props: ['posts'],
        delimiters: ['[[',']]'],
        template: '#home-page-list-view',
    };

    var app = new Vue({
        el: '#app',
        delimiters: ['[[', ']]'],
        components: {
            'home-page-list-view': component1
        },
        data() {
            return {
                offset: 0,
                posts: []
            };
        },
        mounted() {
            if(localStorage.offset)
                this.offset = localStorage.offset;
            if(localStorage.posts)
                this.posts = localStorage.posts;
        },
        methods: {
            get() {
                console.log(this.offset);
                window.axios.get('/api/post/list/' + this.offset).then((response) => {
                    const data = response.data;
                    const posts = data['data'];
                    const count = data['count'];
                    this.offset += count;
                    posts.forEach(post => this.posts.push(new Post(post)));
                });
            },
        },
        created() {
            this.get();
        }
    });
</script>
@endsection
