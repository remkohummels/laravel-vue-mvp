@extends('layouts.email')

@section('content')
    <h2>Password Reset</h2>

    <div>
        To reset your password, complete this form: <a class="btn" href="{{ URL::to('password/reset', $token) }}"> click here</a>
    </div>
@stop