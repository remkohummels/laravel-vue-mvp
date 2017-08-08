@extends('layouts.app')

@section('content')
  <div id="password_reset">
    <div class="login-logo text-center">
      <img src="/images/fready_logo.png"/>
    </div>

    <div class="login-form panel">
      <div class="title panel-heading text-center">
        Reset Password
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('password.request') }}">
          <input type="hidden" name="_token" value={{ $token }}>

          <div class="form-group input {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Password">
            @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group input {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
            @if ($errors->has('confirm_password'))
              <span class="help-block">
                <strong>{{ $errors->first('confirm_password') }}</strong>
              </span>
            @endif
          </div>
          <div class="submit">
            <button type="submit" class="btn btn-lg btn-success btn-block">Reset Password</button>
          </div>
        </form>
      </div>
    </div>
    <div class="copyright text-center">
      &copy; {{ Carbon\Carbon::now()->format('Y') }} Cajun Operating Company, under license by Cajun Funding Corp. All rights reserved.
    </div>
  </div>
@endsection
