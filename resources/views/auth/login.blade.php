@extends('layouts.app')

@section('content')
  <div id="login">
    <div class="login-logo text-center">
      <img src="images/fready_logo.png"/>
    </div>

    <div class="login-form panel">
      <div class="title panel-heading text-center">
        FREADY! Login
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <!--<div class="language text-center">
            Select Language
          </div>-->
          <div class="form-group input {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="text" class="form-control" name="email" placeholder="Email or Restaurant Number" autofocus="autofocus" required="required">
            <i class="fa fa-question-circle-o" data-toggle="modal" data-target="#setHelpModal" aria-hidden="true"></i>
            @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group input {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <a class="forgot" data-toggle="modal" data-target="#setResetPasswordModal">Forgot?</a>
            @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
          </div>
          <div class="remember-me text-center">
            <label>
              <input type="checkbox" name="remember-me" value="remember-me">
              &nbsp;&nbsp;&nbsp;Remember Me
            </label>
          </div>
          <div class="submit">
            <button type="submit" class="btn btn-lg btn-success btn-block">SIGN IN</button>
          </div>
        </form>
      </div>
    </div>
    <div class="help-login text-center">
      <span data-toggle="modal" data-target="#setHelpModal">Need help logging in?</span>
    </div>
    <div class="copyright text-center">
      &copy; {{ Carbon\Carbon::now()->format('Y') }} Cajun Operating Company, under license by Cajun Funding Corp. All rights reserved.
    </div>
    <!-- Modal -->
    <div class="modal fade-scale" id="setHelpModal" tabindex="-1" role="dialog" aria-labelledby="setHelpModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-body">
            <h3 class="title" id="setHelpModalLabel">Need Help?</h3>
            <h4 class="content">
              Forgot your Restaurant Email
              <br/>or password to Fready?
              <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#setResetPasswordModal">Click here.</a>
              <br/><br/>Still need help?
              <br/>Call support 888.888.8888
              <br/>or send an email to:
              <br/><span class="email">support@freadynow.com</span>
            </h4>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade-scale" id="setResetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="setResetPasswordModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
              <h4 class="content">
                Enter Restaurant Number
                <br/>or Email Address:
              </h4>
              <input type="text" name="email"/>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade-scale" id="setSuccessModal" tabindex="-1" role="dialog" aria-labelledby="setSuccessModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-body">
            <h3 class="title" id="setSuccessModalLabel">Thank You!</h3>
            <h4 class="content">
              Please check your email
              <br/>for steps to get you logged in.
            </h4>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade-scale" id="setFailModal" tabindex="-1" role="dialog" aria-labelledby="setFailModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-body">
            <h3 class="title" id="setFailModalLabel">Oops...</h3>
            <h4 class="content">
              We were not able to locate your account.
              <br/>Please call support at: 888.888.8888
              <br/>or email us at: <span class="email">support@freadynow.com</span>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(Session::has('status')))
    <script>
      $(function() {
        $('#set{{ Session::get('status') }}Modal').modal('show');
      });
    </script>
  @endif
@endsection