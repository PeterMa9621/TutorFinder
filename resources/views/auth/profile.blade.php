@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            @if($user->id == Auth::id())
            <form method="post" action="{{ Route('profile', ['id'=>Auth::id()]) }}">
                @csrf
            @endif
                <div class="card">
                    <div class="card-img-top">
                        <button type="button" class="btn btn-outline-primary btn-sm" style="position: absolute; right: 100%" data-toggle="modal" data-target="#upload" onclick="$('#notification').text('');">Upload</button>
                        <img id="avatar" src="{{ $user->avatar==null ? asset('img/default-user-icon.jpeg') : $user->avatar }}" alt="" width="100%">
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

                        <!-- Tutor Part -->
                        <div class="">
                            <div class="card">
                                <div class="card-header">Tutor Profile</div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        @foreach($tutor_attributes as $display_name => $column_name)
                                            <div class="row mt-2">
                                                <div class="col-3">
                                                    <label for="{{ __($column_name) }}" class="mt-2">{{ __($display_name) }}</label>
                                                </div>
                                                <div class="col-9">
                                                    <input id="{{ __($column_name) }}" name="{{ __($column_name) }}" class="form-control" {{ $tutor->user_id == Auth::id() ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $("input").on('change', function () {
                                $('.card-footer').removeClass('invisible');
                            });
                        </script>
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
        <div class="col-sm-4"></div>
    </div>
</div>
<span id="test"></span>
<script>
    $(document).ready(function () {
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

        // Used to get all courses that the user can tutor
        $.ajax({
            url: '{{ route('cantutor.show', ['cantutor'=>$tutor->id]) }}',
            type: 'GET',
            success: function (data) {
                console.log(data);
                data.forEach(function (value, index, array) {
                    let course = value['code'] + ' - ' + value['name'] + ' ';
                    $('#can_tutor').val(function () {
                        return this.value + course;
                    })
                })
            },
            error: function (errorMessage) {
                alert(errorMessage);
            }
        })
    });

</script>
@endsection