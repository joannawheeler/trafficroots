@extends('layouts.app')
@section('title', 'Admin')
@section('js')
	<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
@endsection
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="row">
	<div class="col-md-12">
		<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
			<li><a id="account_tab" href="#account-tab" data-toggle="tab">My Profile</a></li>
			@if($pub)
			<li><a id="pub_tab" href="#pub-tab" data-toggle="tab">Earnings</a></li>
			@endif
			<li><a id="account_tab" href="#buyer-tab" data-toggle="tab">Invoices</a></li>
		</ul>
		<div id="my-tab-content" class="tab-content">
			<div class="tab-pane table-responsive active" id="account-tab">
				<div class="ibox">
					<div class="ibox-content">
						<br>
						@if($user->status == 0)
						
						<div class="alert alert-warning">
							<div class="row">
								<div class="col-md-4">
									<h3>Your Attention Is Needed</h3>
								</div>
								<div class="col-md-8">
									<p>Your E-Mail Address Has Not Been Confirmed!</p>
									<a href="/send_confirmation">
										<button class="btn btn-primary">Click Here To Re-Send Confirmation E-Mail</button>
									</a>
								</div>
							</div>
						</div>
						@endif
						
						<div class="row">
							<form name="profile_form" id="profile_form" class="form-horizontal" role="form" method="POST" action="update_profile">
								{{ csrf_field() }}
								<div class="col-xs-12 col-md-6">
									<br>
									<h2 class="text-success" align="left" style="font-weight: bold;">Account Contact</h2>

										<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
											<label for="name" class="col-md-4 control-label">Name</label>
											<div class="col-sm-8">
												<input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

												@if ($errors->has('name'))
													<span class="help-block">
														<strong>{{ $errors->first('name') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
											<label for="email" class="col-sm-4 control-label">Email</label>
											<div class="col-sm-8">
												<input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>                       
												@if ($errors->has('email'))
													<span class="help-block">
														<strong>{{ $errors->first('email') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
												<label for="url" class="col-sm-4 control-label">Mobile Phone</label>

												<div class="col-sm-8">

													<input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
													@if ($errors->has('phone'))
														<span class="help-block">
															<strong>{{ $errors->first('phone') }}</strong>
														</span>
													@endif
												</div>
											</div>
										<div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
											<label for="company" class="col-sm-4 control-label">Company Name</label>

											<div class="col-sm-8">
												<input id="company" type="text" class="form-control" name="company" value="{{ $user->company }}">

												@if ($errors->has('company_name'))
													<span class="help-block">
														<strong>{{ $errors->first('company_name') }}</strong>
													</span>
												@endif
											</div>
										</div> 

										<h2 class="text-success" align="left" style="font-weight: bold;">Billing Information</h2>

										<div class="form-group{{ $errors->has('addr') ? ' has-error' : '' }}">
											<label for="addr" class="col-sm-4 control-label">Address</label>
											<div class="col-sm-8">
												<input id="addr" type="text" class="form-control" name="addr" value="{{ $user->addr }}" required>

												@if ($errors->has('addr'))
													<span class="help-block">
														<strong>{{ $errors->first('addr') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group{{ $errors->has('addr2') ? ' has-error' : '' }}">
											<label for="addr2" class="col-sm-4 control-label">Address2</label>
											<div class="col-sm-8">
												<input id="addr2" type="text" class="form-control" name="addr2" value="{{ $user->addr2 }}">

												@if ($errors->has('addr2'))
													<span class="help-block">
														<strong>{{ $errors->first('addr2') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
											<label for="city" class="col-sm-4 control-label">City</label>
											<div class="col-sm-8">
												<input id="city" type="text" class="form-control" name="city" value="{{ $user->city }}" required>

												@if ($errors->has('city'))
													<span class="help-block">
														<strong>{{ $errors->first('city') }}</strong>
													</span>
												@endif
											</div>
										</div> 
										<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
											<label for="state" class="col-sm-4 control-label">State</label>
											<div class="col-sm-8">
												<input id="state" type="text" class="form-control" name="state" value="{{ $user->state }}" maxlength="2" required>

												@if ($errors->has('state'))
													<span class="help-block">
														<strong>{{ $errors->first('state') }}</strong>
													</span>
												@endif
											</div>
										</div> 
										<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
											<label for="zip" class="col-sm-4 control-label">Zip/Postal Code</label>
											<div class="col-sm-8">
												<input id="zip" type="text" class="form-control" name="zip" value="{{ $user->zip }}" required>

												@if ($errors->has('zip'))
													<span class="help-block">
														<strong>{{ $errors->first('zip') }}</strong>
													</span>
												@endif
											</div>
										</div> 
										<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
											<label for="country" class="col-sm-4 control-label">Country</label>
											<div class="col-sm-8">
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
								</div>
								<div class="col-xs-12 col-md-6">
									<br>                     
									<h2 class="text-success" align="left" style="font-weight: bold;">Payment Information</h2>
									<div class="form-group">
										<label class="col-sm-4 control-label">Payment Method</label>    
										<div class="col-sm-8">
											<select class="form-control" required>
												<option>Select</option>
												<option>Pay-Pal</option>
												<option>Wire-Bank(Fee May Apply)</option>
												<option>ACH</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">Minimum Payout</label>    
										<div class="col-sm-8">
											<select class="form-control" required>
												<option>Select</option>
												<option>250</option>
												<option>500</option>
												<option>1000</option>
												<option>5000</option>
											</select>
										</div>
									</div>

									<h2 class="text-success" align="left" style="font-weight: bold;">Tax Info</h2>
									<div class="form-group">
										<label class="col-sm-4 control-label">Tax Status</label>    
										<div class="col-sm-8">
											<select class="form-control" required>
												<option>Select</option>
												<option>Company</option>
												<option>Individual</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">Vat/Tax ID</label>
										<div class="col-sm-8"><input placeholder="Vat/Tax ID" class="form-control" type="text"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label"></label>
										<div class="col-sm-8" align="mid"><input placeholder="Future W9 Form" class="form-control" type="text"></div>    
									</div>
								</div>
								<div class="col-xs-12 text-center">
									<br><br>
									<input class="btn btn-primary btn-lg" type="submit" name="submit" id="submit" />
								</div>
							</form>
							
							<div class="col-xs-12">
								<br><br>
								<hr>
								<br><br>
								<h2 class="text-success text-center" align="left" style="font-weight: bold;">Change Password</h2>
								<br><br>
								<form class="form-horizontal">
									<div class="col-xs-12 col-md-offset-2 col-md-6 no-padding">
									<div class="form-group">
										<label align="right" class="col-sm-4 control-label">Existing Password</label>
										<div class="col-sm-8"><input placeholder="Password" class="form-control" type="password"> </div>
									</div>
									<div class="form-group">
										<label align="right" class="col-sm-4 control-label">New Password</label>
										<div class="col-sm-8"><input type="password" class="form-control" name="password" placeholder="Change password"></div>
									</div>
									<div class="form-group">
										<label align="right" class="col-sm-4 control-label">Confirm Password</label>
										<div class="col-sm-8"><input type="password" class="form-control" name="password" placeholder="Confirm password"></div>
									</div>
								</div>
									<br>
									<div class="col-xs-12 text-center">
										<div class="form-group">
											<style>
													hr { 
														display: block;
														margin-top: 0.5em;
														margin-bottom: 0.5em;
														margin-left: auto;
														margin-right: auto;
														border-style: inset;
														border-width: 1px;
														border-color:#1c84c6
													} 
											</style>
											<button type="button" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</div>
								</form>
							</div>	
							
						</div>
						
													
					</div>
				</div>
			</div>
			<div class="tab-pane table-responsive" id="pub-tab">
				<div class="ibox">
				<div class="ibox-content">
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="panel no-border">
								<div class="panel-body col-md-5">
									<h2 class="text-success"><strong>Account Information</strong></h2>
									<table class="table">
										<tbody><tr>
											<td><strong>Account Status:</strong></td>
											<td>Approved</td><!-- Place status of the account -->
										</tr>
										<tr>
											<td><strong>Minimum Payout</strong></td>
											<td>$250</td><!-- Enter the total monthly payout -->
										</tr>
										<tr>
											<td><strong>Payment Terms</strong></td>
											<td>Monthly</td> <!-- Status of the payment terms -->
										</tr>
										<tr>
											<td><strong>Next Payment Due</strong></td>
											<td>Monday, October 30, 2017</td><!-- the day the next payment is due -->
										</tr>
										<tr>
											<td><strong>Next Payment Due</strong></td>
											<td>Monday, October 30, 2017</td><!-- the day the next payment is due -->
										</tr>
										<tr>
											<td><strong>Next Payment Period</strong></td>
											<td>2017-01-01 to 2017-10-30</td><!-- the total length of the campaign -->
										</tr>
										<tr>
											<td><strong>Due Next Period</strong></td>
											<td>$0</td><!-- What is owed next payment period -->
										</tr>
										<tr>
											<td><strong>Total</strong></td>
											<td>Monday, October 30, 2017</td><!-- total amount owed -->
										</tr>
									</tbody></table>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox">
							<div class="panel panel-default">
								<div class="col-xs-12 col-md-6">
									<h4 class="p-title">Payouts</h4>
								</div>
								@if($pub)
								<div class="ibox-content tableSearchOnly">
									<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack">
										<thead>
											<tr>
												<th>Site Name</th>
												<th>Amount</th>
												<th>Date</th>
												<th>Status</th>
												<th>Method</th>
											</tr>
										</thead>
										<tbody>
											@if(sizeof($payments))
												@foreach($payments as $payment)
												<tr>
												<td class="text-center"><b class=" tablesaw-cell-label">Site Name</b>Site Name</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>$ {{ $payment->amount }}</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Date</b>{{ $payment->transaction_date }}</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>Status</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>Method</td>
												</tr>
												@endforeach
											@endif
											@if(sizeof($earnings))
												<!--Unpaid Earnings-->
												@foreach($earnings as $earning)
											<tr>
												<td class="text-center"><b class=" tablesaw-cell-label">Site Name</b>{{ $earning->site_name }}</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>$ {{ $earning->earnings }}</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Date</b>Date</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>Status</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Amount</b>Method</td>
											</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								@else
									<a href="/sites"><h3>Add Your Sites and Start Earning!</h3></a>
								@endif
							</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
			<div class="tab-pane table-responsive" id="buyer-tab">
				<div class="ibox">
					<div class="ibox-content">
						<br>
					@if($buyer)
						<h2 class="text-success"><strong>Account Information</strong></h2>
						<div class="row">
							<div class="col-md-12 no-padding">
								<div class="panel no-border">
									<div class="panel-body col-md-9">
										<table class="table">
											<tbody>
											<tr>
												<td><strong>Account Status:</strong></td>
												<td>Approved</td>
											</tr>
											<tr>
												<td><strong>Current Balance:</strong></td>
												<td>$ {{$balance}}</td>
												<td style="border: 0px; margin-left: 30px; display: block;"><a href="/addfunds"><button class="btn btn-xs btn-primary">Fund Your Account!</button></a></td>
											</tr>
											<tr>
												<td><strong>Month Date Spent:</strong></td>
												<td>$300.00</td>
											</tr>
										</tbody></table>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-12">
								@if(sizeof($invoices))
								<div class="row">
									<div class="col-md-2 alert-info"><h4><strong>Transaction Date</strong></h4></div>
									<div class="col-md-2 alert-info"><h4><strong>Deposit Amount</strong></h4></div>			
								</div>
									@foreach($invoices as $invoice)
									<div class="row">
										<div class="col-md-2">{{ $invoice->transaction_date }}</div>
										<div class="col-md-2">$ {{ $invoice->Amount }}</div>
									</div>
									@endforeach
								@endif    
								@else
								<br>
								<a href="/campaigns"><h4>Start A Campaign!</h4></a>
								@endif
							</div>
						</div>
						<br>
						
						<div class="clearfix"></div>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<div class="panel panel-default">
									<h4 class="p-title">Filter</h4>
									<div class="ibox-content">
										<div class="row">
											<div class="col-xs-12 col-md-5">
												<form name="library_form"
													  method="POST">
													<label>Dates</label>
													<div class="row">
														<div class="col-xs-12 form-group">
															<input hidden="true"
																   type="text"
																   name="daterange" />
															<div id="reportrange"
																 class="form-control">
																<i class="fa fa-calendar"></i>
																<span></span>
															</div>
														<label class="error hide"
															   for="dates"></label>
														</div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-md-6">
															<div class="form-group">
																<button type="submit" class="btn btn-primary btn-block">Submit</button>
															</div>
														</div>

														<div class="col-xs-12 col-md-6">
															<div class="form-group">
																<button type="submit" class="btn btn-danger 	btn-block" id="resetFilter">Reset Filter</button>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	

						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
								<h4 class="p-title">Invoice History</h4>
									<div class="ibox-content">
										<div class="dataTableSearch">
											<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearch dateTableFilter" data-tablesaw-mode="stack">
											<thead> 
											<tr>
												<th>Select</th>
												<th>Name</th>
												<th>Size</th>
												<th>Type</th>
												<th>Total</th>
												<th>Date</th>
												<th class="text-center">Preview</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<label><input type="checkbox"></label>
												</td>
												<td>Bargains</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Size</b><span>26.0 MB</span></td>
												<td class="text-center"><b class=" tablesaw-cell-label">Type</b>
													<button class="btn btn-xs btn-success">CPM</button>
												</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Total</b>125</td>
												<td class="text-center align-center"><span class="tablesaw-cell-content">01/07/2017</span></td>
												<td class="text-center">
													<b class=" tablesaw-cell-label">Preview</b>
													<span class="tablesaw-cell-content">
														<a class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/uploads/823/27a3d8580ab76f5302f7326deeff40d1.jpeg' width='120' height='120'>"><i class="fa fa-camera" aria-hidden="true"></i></a>
													</span>
												</td>
											</tr>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>   
                	</div>
                </div>
            </div>
		</div>       
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#account_tab').click();
});
	
$('.dataTableSearchOnly').DataTable({
	"oLanguage": {
	  "sSearch": "Search Table"
	}, pageLength: 25,
	responsive: true
});

$('.dataTableSearch').DataTable({
		pageLength: 25,
		responsive: true,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy', },
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{extend: 'print',
			 customize: function (win){
				$(win.document.body).addClass('white-bg');
				$(win.document.body).css('font-size', '10px');

				$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
			}
			}
		]
	});

</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_profile').addClass("active");
       });
   </script>
@endsection
