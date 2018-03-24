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
<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                

                <div class="ibox-content">
                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li><a id="account_tab" href="#account-tab" data-toggle="tab">My Profile</a></li>
                        @if($pub)
                        <li><a id="pub_tab" href="#pub-tab" data-toggle="tab">Earnings</a></li>
                        @endif
                        @if($buyer)
                        <li><a id="account_tab" href="#buyer-tab" data-toggle="tab">Invoices</a></li>
                        @endif
                    </ul>
                <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane table-responsive active" id="account-tab">
                    <div class="ibox">
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
            <div class="tab-pane table-responsive" id="pub-tab">
                <div class="ibox">
                <div class="ibox-content">
                @if($pub)
		@if(sizeof($payments))
                <h3>Payouts</h3>
                <div class="row"><div class="col-md-2"><h4>Transaction Date</h4></div>
                    <div class="col-md-2"><h4>Transaction Amount</h4></div></div>
                @foreach($payments as $payment)
                <div class="row"><div class="col-md-2">{{ $payment->transaction_date }}</div>
                    <div class="col-md-2">$ {{ $payment->amount }}</div></div>
	        @endforeach
		@endif
		@if(sizeof($earnings))
		<h3>Current Unpaid Earnings</h3>
                <div class="row"><div class="col-md-2 alert-success"><h4>Site Name</h4></div>
                    <div class="col-md-2 alert-success"><h4>Earnings</h4></div></div>
		@foreach($earnings as $earning)
                <div class="row"><div class="col-md-2">{{ $earning->site_name }}</div>
                    <div class="col-md-2">$ {{ $earning->earnings }}</div></div>
                @endforeach
                @endif
                @else
                <a href="/sites"><h3>Add Your Sites and Start Earning!</h3></a>
                
                @endif
                </div>
                </div>                
            </div>
            <div class="tab-pane table-responsive" id="buyer-tab">
                <div class="ibox">
                <div class="ibox-content">
                    @if($buyer)
                    @if(sizeof($invoices))
                    <h2 class="text-success"><strong>Account Information</strong></h2>
                        <table class="table">
                            <tr>
                                <td><strong>Account Status:</strong></td>
                                <td>Approved</td><!-- Place status of the account -->
                            </tr>
                            <tr>
                                <td><strong>Current Balance:</strong></td>
                                <td>$250.00</td><!-- What is owed next payment period -->
                            </tr>
                            <tr>
                                <td><strong>Month Date Spent:</strong></td>
                                <td>$300.00</td><!-- total amount owed -->
                            </tr>
                        </table>
                    <div class="row"><div class="col-md-2 alert-info"><h4><strong>Transaction Date</strong></h4></div>
                    <div class="col-md-2 alert-info"><h4><strong>Deposit Amount</strong></h4></div></div>
                    @foreach($invoices as $invoice)
                    <div class="row"><div class="col-md-2">{{ $invoice->transaction_date }}</div>
                        <div class="col-md-2">$ {{ $invoice->Amount }}</div></div>
                    @endforeach
                    @endif                
                    @else
                    <a href="/campaigns"><h4>Start A Campaign!</h4></a>
                    @endif
                    <div class="row"><br /><br /><hr></div>
                    <div class="row"><div class="col-md-3">Your Current Balance Is:</div><div class="col-md-3">$ {{$balance}}</div></div>
                    <div class="text-center"><a href="/addfunds"><button class="btn btn-primary">Fund Your Account!</button></a></div>
                    
                    <div class="clearfix"></div>
												<br>
												<div class="row">
													<div class="col-md-5">
													<div class="panel panel-default">
														<h5 class="p-title">Daily Stats</h5>
														<div class="ibox-content">
															<h4>Dates:</h4>
															<div id="date_filter">
																<input class="date_range_filter date" type="hidden" id="datepicker_from" />
																<input class="date_range_filter date" type="hidden" id="datepicker_to" />
															</div>
															<div class="row">
																<div class="col-xs-12">
																	<input type="text" class="form-control dateRangeFilter">
																	<span class="glyphicon glyphicon-calendar fa fa-calendar dateRangeIcon"></span>
																</div>
																<div class="col-xs-12 col-md-6">
																	<br>
																	<button type="submit" class="btn btn-primary btn-block" id="filterSubmit">Submit</button>

																</div>
																<div class="col-xs-12 col-md-6">
																	<br>
																	<button type="submit" class="btn btn-danger btn-block" id="resetFilter">Reset Filter</button>
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
															<h5 class="p-title">Campaigns</h5>
															<div class="dataTableSearch">
																<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearch dateTableFilter" data-tablesaw-mode="stack">
																<thead> 
																<tr>
																	<th>Date</th>
																	<th>Select</th>
																	<th>Name</th>
																	<th>Size</th>
																	<th>Type</th>
																	<th>Total</th>
																	<th class="text-center">Preview</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																	<td class="text-center align-center"><span class="tablesaw-cell-content">01/07/2017</span></td>
																	<td>
																		<label><input type="checkbox"></label>
																	</td>
																	<td>Bargains</td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Size</b><span>26.0 MB</span></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Type</b>
																		<button class="btn btn-xs btn-success">CPM</button>
																	</td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Total</b>125</td>
																	<td class="text-center">
																		<b class=" tablesaw-cell-label">Preview</b>
																		<span class="tablesaw-cell-content">
																			<a class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/uploads/823/27a3d8580ab76f5302f7326deeff40d1.jpeg' width='120' height='120'>"><i class="fa fa-camera" aria-hidden="true"></i></a>
																		</span>
																	</td>
																</tr>
																<tr>
																	<td class="text-center align-center"><span class="tablesaw-cell-content">03/05/2018</span></td>
																	<td><label><input type="checkbox"></label></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Name</b><span class="tablesaw-cell-content">Act Now</span></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Size</b><span>31.0 MB</span></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Type</b>
																		<button class="btn btn-xs btn-warning">CPC</button>
																	</td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Total</b>30</td>
																	<td class="text-center">
																		<b class=" tablesaw-cell-label">Preview</b>
																		<span class="tablesaw-cell-content">
																			<a class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/uploads/823/27a3d8580ab76f5302f7326deeff40d1.jpeg' width='120' height='120'>"><i class="fa fa-camera" aria-hidden="true"></i></a>
																		</span>
																	</td>
																</tr>
																<tr>
																	<td class="text-center align-center"><span class="tablesaw-cell-content">02/21/2017</span></td>
																	<td><label><input type="checkbox"></label></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Name</b><span class="tablesaw-cell-content">California Bargains</span></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Size</b><span>0.0 MB</span></td>
																	<td class="text-center"><b class=" tablesaw-cell-label">Type</b>
																		<button class="btn btn-xs btn-success">CPM</button>
																	<td class="text-center"><b class=" tablesaw-cell-label">Total</b>652</td>
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
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#account_tab').click();
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
