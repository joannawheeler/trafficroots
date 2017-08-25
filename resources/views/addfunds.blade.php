@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="ibox float-e-margins">
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
                <div class="ibox-title"><h1>Add funds with Credit or EFT</h1></div>
                <div class="ibox-content">
                       <div><p>Your current balance is $ {{ $balance }}</p>
                        <p>Minimum deposit is $100.00</p>
                        <p>You may increase the amount at the processor</p></div>
                        <button 
                            class="velocity-button btn btn-outline btn-primary dim"
                            data-billing="billinginfo|bname|baddress|bcity|bstate|bzip|bcountry|bemail|bphone"
                            data-public-key="x"
                            data-description="Traffic Roots Deposit"
                            data-invoice-no="123"
                            data-amount="100.00"
                            data-callback-function="onPaymentCompletion"
                            data-optional-parameters="useReference"
                            data-merchant-name="Traffic Roots">
                            <i class="fa fa-money"></i> Add Funds
                        </button>                 
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://api.cert.nabcommerce.com/1.2/button.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#payment-form").submit(function(){
            if($("#amount").val() > 0.00){
                alert("Good Boy!");
            }else{
                alert("Bad Boy");
            }
            return false;
        });
    });
    function onPaymentCompletion(response){
        alert(JSON.stringify(response));
    }
</script>
@endsection
