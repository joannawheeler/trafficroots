@extends('layouts.app') 

@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Reset Password</h5>
                </div>
		<div class="ibox-content">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
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
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" type="submit">Send Password Reset Link</button>
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

@endsection
