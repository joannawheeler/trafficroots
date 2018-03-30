@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-offset-3 col-xs-12 col-md-6">
		<div class="panel text-center" style="border: 1px; background-color: #1a7bb9; color: #fff;">
			@if ($message = Session::get('success'))
			<div class="custom-alerts alert alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{!! $message !!}
			</div>
			<?php Session::forget('success');?>
			@endif
			@if ($message = Session::get('error'))
			<div class="custom-alerts alert alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{!! $message !!}
			</div>
			<?php Session::forget('error');?>
			@endif
			<div class="p-title">
				<h1><strong>Add Funds With a Credit Card</strong></h1>
			</div>
			<div class="ibox-content text-center" style="color: #676a6c;">
				<br>
				<h4>Current Balance</h4>
				<h1 class="text-navy">
				   <strong>$ {{ $balance }}</strong>
				</h1>
				<br><br>
					<h2 class="text-success" style="font-weight: bold;">Deposit</h2>
					@if($amount)
					<h4>Amount to Deposit</h4>
					<h1>$ {{ number_format($amount,2) }}</h1>
					<br /><br />
					<div class="col-xs-12 no-padding"><hr></div>
					<button
						id="mybutton" class="btn btn-md btn-warning fundsSuccess"
						class="velocity-button"
						data-description="{{ $user->name }} - Traffic Roots Deposit"
						data-invoice-num="{{ $user_invoice }}"
						data-amount="{{ number_format($amount,2) }}"
						data-callback-function="onPaymentCompletion"
						data-merchant-name="Traffic Roots"
						data-terminal-profile-id="6830">
						<span class="fa fa-money"></span> Add Funds
					</button> 
					<a class="btn btn-default CancelFunds" href="#">Cancel</a>
					<input type="hidden" name="invoice" id="invoice" value="{{ $user_invoice }}">
					{{ csrf_field() }}  
					@else
						<p>Minimum deposit: $250.00</p>
						<br>
						<div class="col-xs-12 text-center">
							<input class="form-control" 
								   style="width: unset; margin: 0 auto; text-align: center;
										  font-size: 20px; padding: 25px 0px;" 
							type="text" name="amount" id="amount" value="{{ $amount }}">
							<br />
						</div>
						<div class="col-xs-12 no-padding"><hr></div>
						<button id="mybutton" class="btn btn-md btn-primary" onclick="return checkDeposit();">Continue</button>
						<a class="btn btn-default CancelFunds" href="#">Cancel</a>
					@endif              
			</div>
		</div>
	</div>
</div>
<script src="https://api.nabcommerce.com/1.3/button.js"></script>
<script src="{{ URL::asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
		$(".CancelFunds").click(function() {
			swal({
				title: "Cancel Funds",
				text: "Are you sure you want to cancel adding funds?", 
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((cancel) => {
				if (cancel) {
					window.location.href = "profile";
				}
			}); 
		});
				
		$(".fundsSuccess").click(function() {
			swal({
			  title: "Success!",
			  text: "You added more funds!",
			  icon: "success",
			}).then(() => {
				window.location.replace("profile");
        	});
		});
		
	    $('.nav-click').removeClass("active");
	    $('#nav_profile').addClass("active");       
    });
    function onPaymentCompletion(response){
            if(!response) {
                console.log('User Cancelled');
                return false;
            }
            console.log(JSON.stringify(response));
            
            var poststring = '_token={{ csrf_token() }}&invoice={{ $user_invoice }}&Status=' + response.Status + '&StatusCode=' + response.StatusCode + '&StatusMessage=' + response.StatusMessage + '&TransactionId=' + response.TransactionId + '&CaptureState=' + response.CaptureState + '&TransactionState=' + response.TransactionState + '&Amount=' + response.Amount + '&CardType=' + response.CardType + '&ApprovalCode=' + response.ApprovalCode + '&MaskedPAN=' + response.MaskedPAN + '&PaymentAccountDataToken=' + response.PaymentAccountDataToken;
            var url = "{{ url('/deposit') }}";
            alert(poststring);
            $.post(url,poststring, function(data){
                alert(data);
            });
            window.location = '/buyers/account';            
    }
    function checkDeposit(){
        var amount = $("#amount").val();
        if(amount >= 250){
            window.location = window.location.href = '?deposit=' + amount;
            return false;
        }else{
			swal({
				title: "Error",
				text: "The minimum deposit is $250.00", 
				icon: "warning",
			}); 
			
			return false;
        }

    }
</script>
@endsection
