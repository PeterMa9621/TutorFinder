@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    {{ __($course->code . ' ' . $course->name) }}
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-light">
                            <tr>
                                <th scope="row">Tutoring Content:</th>
                                <td>
                                    {{ $tutoring_content->content }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Tutoring Date:</th>
                                <td>
                                    {{ $post->when }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Poster Name:</th>
                                <td>
                                    {{ $poster->name }}
                                </td>
                            </tr>
                            @if($poster->id == Auth::id() || (isset($show_contact) && $show_contact==true))
                            <tr>
                                <th scope="row">Poster Email:</th>
                                <td>
                                    {{ $poster->email }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Poster Wechat:</th>
                                <td>
                                    {{ $poster->wechat }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Poster Facebook:</th>
                                <td>
                                    {{ $poster->facebook }}
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                @if(!isset($show_contact))
                <div class="card-footer">
                    @if(Auth::user()->id == $poster->id)
                        <div class="form-inline">
                            <a class="btn btn-primary mr-2" href="{{ route('edit_post', ['id'=>$post->id]) }}">Edit The Post</a>
                            <form method="post" action="{{ route('close_post', ['id'=>$post->id]) }}">
                                @csrf
                                <input type="submit" name="close" class="btn btn-warning" value="{{ $post->closed_at==null?'Close the Post':'Open the Post' }}">
                            </form>
                        </div>

                    @elseif(Auth::user()->id != $poster->id && Auth::user()->is_tutor==true)
                    <form method="post" action="{{ route('post_contact', ['id'=>$post->id]) }}">
                        @csrf
                        <input type="submit" name="contact" class="btn btn-primary" value="Get Contact Information">
                    </form>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection