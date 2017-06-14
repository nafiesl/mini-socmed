@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $user->name }}</h3></div>
            <div class="panel-body">
                <label>Email:</label>
                <p>{{ $user->email }}</p>
                @if (auth()->check() && auth()->id() != $user->id)
                <friendbutton :profile_user_id="{{ $user->id }}" :current_user_id="{{ auth()->id() }}"></friendbutton>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection