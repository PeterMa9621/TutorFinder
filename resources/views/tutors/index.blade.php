@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Find Tutors</div>

                @if(sizeof($tutors)==0)
                    <div class="card-body">No tutors</div>
                @else
                    <div class="list-group">
                        @foreach($tutors as $tutor)
                            <a id="post" href="{{ route('profile', ['id'=>$tutor->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-2">
                                            <img src="{{ $tutor->avatar==null ? asset('img/default-tutor-icon.jpg') : $tutor->avatar }}" alt="" width="100%">
                                        </div>
                                        <div class="col-10">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h4 class="mb-1">{{ $tutor->name }}</h4>
                                                <small>{{ $tutor->created_at }}</small>
                                            </div>
                                            <p class="mb-1">{{ $tutor->email }}</p>
                                            <p class="mb-1">{{ $tutor->wechat }}</p>
                                            <p class="mb-1">{{ $tutor->facebook }}</p>
                                        </div>
                                    </div>
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
