@extends('layouts.app')
@section('title', '- Profile')
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">My Profile</div>

                <div class="ibox-content">
                <form name="profile_form" id="profile_form" class="form-horizontal" role="form" method="POST" action="update_profile">
                {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" value="{{ $user->company }}">

                                @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('addr') ? ' has-error' : '' }}">
                            <label for="addr" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="addr" type="text" class="form-control" name="addr" value="{{ $user->addr }}" required>

                                @if ($errors->has('addr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('addr2') ? ' has-error' : '' }}">
                            <label for="addr2" class="col-md-4 control-label">Address2</label>

                            <div class="col-md-6">
                                <input id="addr2" type="text" class="form-control" name="addr2" value="{{ $user->addr2 }}">

                                @if ($errors->has('addr2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addr2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ $user->city }}" required>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-4 control-label">State</label>

                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{ $user->state }}" maxlength="2" required>

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-md-4 control-label">Zip/Postal Code</label>

                            <div class="col-md-6">
                                <input id="zip" type="text" class="form-control" name="zip" value="{{ $user->zip }}" required>

                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label for="country" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <select id="country" class="form-control" name="country" required>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                @if($country->id == $user->country_code)
                                selected
                                @endif
                                >{{ $country->country_name }}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                 
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>                       
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="url" class="col-md-4 control-label">Mobile Phone</label>

                            <div class="col-md-6">

                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       <div class="form-group">
                            <label for="submit" class="col-md-4 control-label">Submit Changes</label>
                            <div class="col-md-6">
                                <input type="submit" name="submit" id="submit" />
                            </div>
                       </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    });

</script>
@endsection
