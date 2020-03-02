@extends('layouts.app')

@section('content')
<!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
<link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}" />
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('js/rainbow-custom.min.js') }}"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Edit my post
                </div>
                <form id="form" class="form-group" method="post" action="">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="course">{{ __('Course') }}</label>
                                <select name="course" id="course" class="form-control">
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ $course->id == $post->course ? 'selected' : '' }}>
                                            {{ $course->code . ' - ' . $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoring_content">{{ __('Tutoring Content') }}</label>
                                <select name="tutoring_content" id="tutoring_content" class="form-control">
                                    @foreach($tutoring_contents as $tutoring_content)
                                        <option value="{{ $tutoring_content->id }}" {{ $tutoring_content->id == $post->tutoring_content ? 'selected' : '' }}>
                                            {{ $tutoring_content->content}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="when">{{ __('Tutoring Date') }}</label>
                                <input name="when" id="when" type="text" class="form-control" placeholder="Click to choose a meeting time" autocomplete="off" value="{{ $post->when }}">
                                <script>
                                    $(document).ready(function() {
                                        $('#when').datetimepicker({
                                            format:'Y-m-d H:i',
                                            step: 30
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Edit" onclick="$('#form').attr('action', '{{ route('edit_post', ['id'=>$post->id]) }}')">
                        <input type="submit" class="btn btn-danger" value="Delete" onclick="$('#form').attr('action', '{{ route('delete_post', ['id'=>$post->id]) }}')">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection