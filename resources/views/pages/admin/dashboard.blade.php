@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            Admin Dashboard
            <a href="/logout" class="pull-right">Logout</a>
          </div>

          <div class="panel-body">
            You are logged in!
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
