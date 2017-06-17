@extends('layouts.app') 
<!-- facebook stuff -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=107703369819007";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- end facebook stuff -->

<!-- google api -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="266526603130-bfbtte99f9j5hngg23v0bjqu209fc8rq.apps.googleusercontent.com">

@section('css')
<link href="css/plugins/iCheck/custom.css" rel="stylesheet"> 
@endsection

@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Login</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }} {{--
                        <p>Sign in today for more expirience.</p> --}}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-lg-2 control-label">Email</label>

                            <div class="col-lg-10">
                                <input type="email" placeholder="Email" name="email" class="form-control"> 
                                @if ($errors->has('email'))
                                <span class="help-block m-b-none">{{ $errors->first('email') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-lg-2 control-label">Password</label>

                            <div class="col-lg-10">
                                <input type="password" placeholder="Password" name="password" class="form-control"> 
                                @if($errors->has('password'))
                                <span class="help-block m-b-none">{{ $errors->first('password') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox" name="remember"><i></i> Remember me </label>
                                </div>
                                <a href="password/reset"><small>Forgot password?</small></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                    <div class="fb-login-button center" data-max-rows="1" data-onlogin="checkLoginState();" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="true" data-use-continue-as="true"></div>
                    <br /><div class="g-signin2" data-onsuccess="onGoogleSignIn"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('js')
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    setTimeout(checkLoginState, 3000);
});

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    alert(response.status);
    statusChangeCallback(response);
  });
}

function statusChangeCallback(response){
    if(response.status == 'connected'){
        FB.api('/me?fields=id,name,email,permissions', function(myresponse) {
            console.log('Successful login for: ' + myresponse.name);
            var url = '/fblogin/' + response.authResponse.accessToken + '/' + response.authResponse.userID + '/' + myresponse.name + '/' + myresponse.email;
            $.get(url,function(data){
                var info = JSON.parse(data);
                alert(info.status);
            });
        });        
    }
}

function onGoogleSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
</script>
@endsection
