@extends('layouts.app') 
@section('css')
<link href="css/plugins/iCheck/custom.css" rel="stylesheet"> 
@endsection 

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5></h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }} 
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-10">
                                <input id="name" type="name" placeholder="Name" name="name" class="form-control"> 
                                @if ($errors->has('name'))
                                <span class="help-block m-b-none">{{ $errors->first('name') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input id="email" type="email" placeholder="Email" name="email" class="form-control">
                                @if ($errors->has('email'))
                                <span class="help-block m-b-none">{{ $errors->first('email') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="company" class="col-lg-2 control-label">Company</label>
                            <div class="col-lg-10">
                                <input id="company" type="text" placeholder="Company Name" name="company" class="form-control">
                                @if ($errors->has('company'))
                                <span class="help-block m-b-none">{{ $errors->first('company') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-10">
                                <input id="password" type="password" placeholder="Password" name="password" class="form-control">
                                @if($errors->has('password'))
                                <span class="help-block m-b-none">{{ $errors->first('password') }}</span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-lg-2 control-label">Confirm</label>
                            <div class="col-lg-10">
                                <input id="password-confirm" type="password" placeholder="Confirm password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-white" type="submit">Register</button>
                            </div>
                        </div>
    <hr>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3 text-center">
            <h4>or...login with</h4>
            <a href="{{ url('/auth/google') }}" class="btn btn-google"><i class="fa fa-google"></i> Google</a>
            <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
        </div>
    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
 {{-- @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Publisher Registration</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> 
                                    @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> 
                                    @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}"> @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span> 
                                    @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> 
                                    @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
    <hr>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3 text-center">
            <h4>or...login with</h4>
            <a href="{{ url('/auth/google') }}" class="btn btn-google"><i class="fa fa-google"></i> Google</a>
            <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
        </div>
    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.nav-click').removeClass("active");
    $('#nav_register').addClass("active");
});
</script>
@endsection --}} 

@section('js')
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    setActiveNav('#nav_register');
});

</script>
@endsection
