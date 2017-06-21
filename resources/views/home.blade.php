@extends('layouts.app')

@section('content')
<post></post>
<feed :current_user_id="{{ auth()->id() }}"></feed>
@endsection
