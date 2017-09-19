<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\Bank;
use Auth;
use DB;
use Log;

class CreditAchController extends Controller
{
    /* handle funds via Velocity merchant account */

    public $amount = 0.00;
    
    public function __construct()
    {
        $this->middleware('auth');
    }   
    
    public function getIndex(Request $request)
    {
        /* show the page to add funds via CC or EFT */
        $amount = isset($request->deposit) ? intval($request->deposit) : 0.00;
        $balance = $this->getBalance();
        $user = Auth::getUser();
        $user_invoice = $user->id . "_" . uniqid();
        return view('addfunds',['balance' => $balance, 'user_invoice' => $user_invoice, 'user' => $user, 'amount' => $amount]);

    }
  
    public function postFunds(Request $request)
    {
        /* handle deposits after response from processor */
        

        return view('addfunds',['result' => $result]);   
    }

    public function getBalance()
    {
        $user = Auth::getUser();
        $bank = Bank::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        if(!$bank){
            $data = array();
            $data['user_id'] = $user->id;
            $data['transaction_amount'] = 20.00;
            $data['running_balance'] = 20.00;
            $bank = new Bank();
            $bank->fill($data);
            $bank->save();
            $balance = 0;
        }else{
            $balance = $bank->running_balance;
        }
        return $balance;
    }

    public function depositFunds(Request $request)
    {
      try{
        $user = Auth::getUser();
        $balance = $this->getBalance();
        $running_balance = ($balance + $request->amount);
        $data = array('user_id' => $user->id, 'transaction_amount' => $request->amount, 'running_balance' => $running_balance);
        $bank = new Bank();
        $bank->fill($data);
        $bank->save();
        
        /* figure something out here
        $sql = "INSERT INTO trafficroots.paypal (id,paypal_id,bank_id,created_at,updated_at) VALUES(NULL,'$payment_id',".$bank->id.",NOW(),NOW());";
        DB::insert($sql);
        */
        return true;
      }catch(Exception $e){
          Log::error($e->getMessage());
          return false;
      }

    }
}
