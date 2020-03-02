@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Recent Posts</div>

                @if(sizeof($posts)==0)
                    <div class="card-body">No posts</div>
                @else
                    <div class="list-group">
                        @foreach($posts as $post)
                            <a id="post" href="{{ route('post_detail', ['id'=>$post->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h4 class="mb-1">{{ $post->tutoring_content }}</h4>
                                    <small>{{ $post->created_at }}</small>
                                </div>
                                <p class="mb-1">Preferred tutoring time: <strong style="color: #2e19ec;">{{ $post->when }}</strong></p>
                                <div class="d-flex w-100 justify-content-between">
                                    <small class="mb-1">{{ $post->course }}</small>
                                    <small>{{ $post->username }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.list-group-item').hover(function () {
            $(this).addClass('active');
        }, function () {
            $(this).removeClass('active');
        });
    });
</script>
@endsection
