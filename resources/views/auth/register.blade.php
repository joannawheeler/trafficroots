@extends('layouts.app') 
@section('css')
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet"> 
<link href="css/custom.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
@endsection 

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

<div class="login-container" style:"margin-bottom: 0px;">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg tree-bg" style="margin: 0px;">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 m-t-lg clearfix">
                        <div class="ibox-title"><h3>Register</h3>
                    </div>
                    <div class="ibox-content clearfix">
                        <form class="form-horizontal" role="form" id="registrationform" method="POST">
                            <input type="hidden" name="_token" value="jEBYi6NttG1WHgPNSXH6mKg9G2e0AzS7rZuog1GX"> 
							<input type="hidden" name="formId" value="2W7UI+OZYzFhmO4xQQWvcQ==" />
                            <p>Please fill out your information below.</p><br>
                            {{ csrf_field() }} 
                            
                                <div class="form-group">
                                    <label for="selectRole" class="col-lg-2 control-label">Select role</label>
                                    <div class="col-lg-10">
                                        <select name="selectRole" class="form-control" required>
                                            <option value="">Select A Role</option>
                                            <option value="publisher">Publisher</option>
                                            <option value="advertiser">Advertiser</option>
                                            <option value="both">Both</option>
                                        </select>
                                        <!--   Do not erase I want to incorporate this feature in the future
                                        <button data-toggle="toggle" class="btn btn-success btn-outline" type="button" value="publisher"><h3>Publisher</h3></button> or
                                        <button data-toggle="toggle" class="btn btn-warning btn-outline" type="button" value="advertiser"><h3>Advertiser</h3></button> or
                                        <button data-toggle="toggle" class="btn btn-primary btn-outline" type="button" value="both"><h3>Both</h3></button>
                                        -->
                                    </div>
                                </div>
                            
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input id="name" type="name" placeholder="Your Full Name" name="name" class="form-control"> 
                                    @if ($errors->has('name'))
                                    <span class="help-block m-b-none">{{ $errors->first('name') }}</span> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input id="email" type="email" placeholder="Your Email" name="email" class="form-control">
                                    @if ($errors->has('email'))
                                    <span class="help-block m-b-none">{{ $errors->first('email') }}</span> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="company" class="col-lg-2 control-label">Company</label>
                                <div class="col-lg-10">
                                    <input id="company" type="text" placeholder="Your Company's Name" name="company" class="form-control">
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
                                    <div class="g-recaptcha" data-sitekey="6LfwKzUUAAAAAECCj-_5tID_aAm3-oYxBspUTrw0"></div>
                                </div>
                            </div>
                            
                                <div id="StayConnected">
                                    <h3>Stay Connected</h3>
                                    <label class="col-xs-2 col-md-1 control-label"><i class="fa fa-linkedin-square"></i></label>
                                    <div class="col-xs-10 col-md-5"><input type="text" placeholder="LinkedIn Account" class="form-control"></div>
                                    <label class="col-xs-2 col-md-1 control-label"><i class="fa fa-facebook-square"></i></label>
                                    <div class="col-xs-10 col-md-5"><input type="text" placeholder="Facebook Account" class="form-control"></div>
                                    <label class="col-xs-2 col-md-1 control-label"><i class="fa fa-instagram"></i></label>
                                    <div class="col-xs-10 col-md-5">
                                        <input type="text" placeholder="Instragram Account" class="form-control">
                                    </div>
                                    <label class="col-xs-2 col-md-1 control-label"><i class="fa fa-twitter-square"></i></label>
                                    <div class="col-xs-10 col-md-5"><input type="text" placeholder="Twitter Account" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 text-center"><br>
                                    <div class="form-group">
                                        <div class="checkbox i-checks"><label> 	
                                            <div class="icheckbox_square-green" required style="position: relative;">
                                                <input type="checkbox" required style="opacity:inherit;">
                                                <ins class="iCheck-helper"></ins>
                                            </div>
                                            <a href="terms.html"> Agree to the terms and Conditions</a></label>
                                        </div>
                                    </div>
                                    <!--recaptcha-->
                                    <br>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" value="Submit"><strong>Submit</strong></button>
                                        <button class="btn btn-danger" id="cancel"><strong>Cancel</strong></button>
                                    </div>
                                </div>
                            
                            
                            
                                <!-- <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button class="btn btn-sm btn-primary" type="submit">Register</button>
                                    </div>
                                </div> -->
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3 text-center">
                                        <h4>or...login with</h4>
                                        <a href="{{ url('/auth/google') }}" class="btn btn-google"><i class="fa fa-google"></i> Google</a>
                                        <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                                    </div>
                                </div>
                        </form>
						
						<form id="insightly_web_form" name="insightly_web_to_lead" action="https://crm.na1.insightly.com/WebToLead/Create" method="post" style="display:block;">
							<input type="hidden" name="formId" value="2W7UI+OZYzFhmO4xQQWvcQ==" /><label for="insightly_firstName">First Name: </label>
							<input id="insightly_firstName" name="FirstName" type="text"/><br/><label for="insightly_lastName">Last Name: </label>
							<input id="insightly_lastName" name="LastName" type="text"/><br/><label for="insightly_organization">Organization: </label>
							<input id="insightly_organization" name="OrganizationName" type="text"/><br/><label for="email">Email: </label>
							<input id="insightly_Email" name="email" type="text"/><br/><label for="phone">Phone: </label>
							<input id="insightly_Phone" name="phone" type="text"/><br/><label for="insightly_title">Title: </label>
							<input id="insightly_Title" name="Title" type="text"/><br/><input type="hidden" id="insightly_ResponsibleUser" name="ResponsibleUser" value="1184940"/>
							<input type="hidden" id="insightly_LeadSource" name="LeadSource" value="1234460"/>
							<input type="submit" value="Submit">
						</form>
                    </div>
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
            <div class="ibox">
                <div class="ibox-title">Publisher Registration</div>
                <div class="ibox-content">
                    <form class="form-horizontal" role="form" method="POST" action="">
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

@endsection --}} 

@section('js')
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/icheck.min.js"></script>
<script>
$(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
	
	$('.icheckbox_square-green input').css("opacity", "inherit");
    setActiveNav('#nav_register');

    //alert("test");
    $('.nav-click').removeClass("active");
    $('#nav_register').addClass("active");
    $(".no-skin-config").removeAttr("style");

	$('#registrationform').submit(function(e){
	//$('form').submit(function(e){
		 event.preventDefault();
		$('#insightly_firstName').val( $('#name').val() ); //First name
		$('#insightly_lastName').val( $('#name').val() ); //Last name
		$('#insightly_Email').val( $('#email').val() ); //Email
		$('#insightly_organization').val("None");
		$('#insightly_Title').val("NA");
//		$('phones[0]_Value').val( $('#field-1').val() ); //Phone
//		$('insightly_background').val( $('#field-1').val() ); //Title
		//document.getElementById("insightly_web_form").submit();
			alert("submit button clicked");
		$.ajax({
            type: "POST",
            url: "{{ url('/register') }}",
			//url: "https://crm.na1.insightly.com/WebToLead/Create",
			data: $(this).serialize(),
			//crossDomain: false,
			//dataType: 'jsonp',			
//			dataType: 'JSON',
//    		jsonpCallback: 'callback',
            success: function() { //alert("Success"); 
				document.getElementById("insightly_web_form").submit();
			},
			error: function() { alert('Failed!'); }				
        });
        e.preventDefault();
	});
});
</script>
@endsection
