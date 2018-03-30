@extends('layouts.app')
@section('content')
<style>
    .navbar-static-top {
       display: none;
   }
   .navbar-static-side {
       display: none;
   }
   #page-wrapper {
       padding: 0;
       margin: 0;
   }
</style>
<div class="login-container">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg tree-bg" style="margin: 0px;">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 m-t-lg" id="SignIN">
                        <div class="ibox-title"><h3>Forgot Password</h3>
						</div>
                        <div class="ibox-content">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                {{ csrf_field() }} {{--
                                <p>Sign in today for more experience.</p> --}}
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email</label>
                                    <input type="email" placeholder="Email" name="email" class="form-control">
                                    @if ($errors->has('email'))
                                    <span class="help-block m-b-none">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
								<div class="centered-block"><br>
									<button class="btn btn-primary" type="submit" value="Submit"><strong>Send Email</strong></button>
									<button class="btn btn-danger" id="cancel"><strong>Cancel</strong></button>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.no-skin-config').removeAttr('style');
    });
</script>


@endsection
