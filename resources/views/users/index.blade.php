@extends('layouts.app')

@section('content')
<h3 class="page-header">Browse Users</h3>

<div class="row">
@foreach($users as $user)
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ $user->name }}</h3></div>
        <div class="panel-body">
            <label>Email:</label>
            <p>{{ $user->email }}</p>
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-xs">View Profile</a>
        </div>
    </div>
</div>
@endforeach
</div>
@endsection