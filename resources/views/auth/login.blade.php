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
});
</script>
@endsection
