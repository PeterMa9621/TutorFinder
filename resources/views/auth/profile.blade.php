@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-md-2"></div>
        <div class="col-xl-6 col-md-8">
            @if($user->id == Auth::id())
            <form method="post" action="{{ Route('profile', ['id'=>Auth::id()]) }}">
                @csrf
            @endif
                <div class="card" style="border: none">
                    <div class="card-img-top">
                        <button type="button" class="btn btn-outline-primary btn-sm" style="position: absolute; right: 100%" data-toggle="modal" data-target="#upload" onclick="$('#notification').text('');">Upload</button>
                        <div class="row justify-content-center">
                            <img id="avatar" src="{{ $user->avatar==null ? asset('img/default-user-icon.jpeg') : $user->avatar }}" alt="" width="60%">
                        </div>

                    </div>
                    <div class="card-body">
                        <!-- User Part -->
                        <div class="form-group">
                            <div class="card">
                                <div class="card-header">User Profile</div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        @foreach($user_attributes as $display_name => $column_name)
                                            <div class="row mt-2">
                                                <div class="col-3">
                                                    <label for="{{ __($column_name) }}" class="mt-2">{{ __($display_name) }}</label>
                                                </div>
                                                <div class="col-9">
                                                    <input id="{{ __($column_name) }}" name="{{ __($column_name) }}" class="form-control" value="{{ $user[$column_name] }}" {{ $user->id == Auth::id() ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- User Part End -->
                        @if(isset($tutor))
                        <!-- Tutor Part -->
                        <div class="form-group">
                            <div class="card">
                                <div class="card-header">Tutor Profile</div>
                                <div class="card-body">
                                    <template id="can-tutor-course-list" :courses="courses">
                                        <div class="card">
                                            <div class="card-header">
                                                Courses can be tutoring
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group">
                                                    <a v-for="course in courses" href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-2 my-auto">
                                                                    <img src="{{ asset('img/default-tutor-icon.jpg') }}" alt="" width="100%">
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1">[[ course.code ]]</h5>
                                                                    </div>
                                                                    <p class="mb-1">[[ course.name ]]</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <!-- Tutor Part End -->

                        <!-- Comment Part Only For Tutors -->
                        <div class="">
                            <template id="comment-component">
                                <div class="card">
                                    <div class="card-header">
                                        Comments
                                    </div>
                                    <!-- Leave Comment Part -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="comment_box">Leave Comments:</label>
                                            <textarea id="comment_box" class="form-control" rows="4" placeholder="Leave comments for this tutor..." v-model="new_comment"></textarea>
                                            <div class="row justify-content-end">
                                                <button class="btn btn-outline-primary mt-2 mr-3" @click="app.add_comment()">Submit</button>
                                            </div>
                                        </div>

                                        <!-- Show Comments Below -->
                                        <div>
                                            <hr>
                                            <comment-component></comment-component>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <!-- Comment Part End -->
                        @endif
                    </div>
            @if($user->id == Auth::id())
                    <div class="card-footer" id="modify">
                        <input class="btn btn-primary" type="submit">
                    </div>
                </div>
            </form>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="uploadTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadLongTitle">Upload Photo</h5>
                            <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="upload-form" action="{{ route('profile_upload', ['id'=>$user->id]) }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input id="file" name="file" type="file">
                                <span id="notification"></span>
                            </div>
                            <div class="modal-footer">
                                <button id="dismiss-upload-modal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input id="upload" type="submit" class="btn btn-primary" value="Upload">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-2"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Upload avatar
        $('#upload-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('profile_upload', ['id'=>$user->id]) }}',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#notification').text('Upload files...');
                    $('#modal-close').hide();
                    $('#dismiss-upload-modal').prop('disable', true);
                    $('#upload').prop('disable', true);
                    $('#file').prop('disable', true);
                },
                success: function (data) {
                    $('#notification').text('Succeed...');
                    $('#dismiss-upload-modal').click();
                    $('#avatar').attr('src', data);
                },
                error: function (errorMessage) {
                    $('#notification').text('Failed...' + errorMessage);
                },
                complete: function () {
                    $('#modal-close').show();
                    $('#dismiss-upload-modal').prop('disable', false);
                    $('#upload').prop('disable', false);
                    $('#file').prop('disable', false);
                }
            });
        });
    });

    // Vue.js Part Below
    // Used to get all courses that the user can tutor
    @if(isset($tutor))

    const comment_component = {
            delimiters: ['[[', ']]'],
            props: ['comments'],
            template: '#comment-component'
        };

    var component = {
        props: ['courses'],
        template: '#can-tutor-course-list'
    };

    var app = new Vue({
        el: '#app',
        delimiters: ['[[', ']]'],
        data() {
            return {
                courses: [],
                comments: [],
                new_comment: undefined,
                new_score: 5.0
            }
        },
        components: {
            'can-tutor-course-list': component,
            'comment-component': comment_component
        },
        methods: {
            get_courses() {
                window.axios.get("{{ route('cantutor.show', ['cantutor'=>$tutor->id]) }}").then((response) => {
                    const data = response.data;
                    data.forEach(course => {this.courses.push(course)});
                });
            },
            get_comments() {
                window.axios.get("{{ route('tutor_comment.show', ['tutor_comment'=>$tutor->id]) }}").then((response) => {
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
            this.get_courses();
            this.get_comments();
        }
    });
    @endif

</script>
@endsection