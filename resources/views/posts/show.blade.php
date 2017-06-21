@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $post->user->name }}</h3></div>
            <div class="panel-body">
                {{ $post->content }}
            </div>
            <div class="panel-footer">
                <like :post="{{ $post }}" :current_user_id="{{ auth()->id() }}"></like>
            </div>
        </div>
    </div>
</div>
@endsection
