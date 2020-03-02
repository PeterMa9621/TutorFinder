@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Success
                </div>
                <div class="card-body">
                    {{ $content }}
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection