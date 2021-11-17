<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    private $AccountController;

    public function __construct()
    {
        $this->AccountController = new AccountController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function GetTransactions($transactions, $state)
    {
        $response = [];

        foreach ($transactions as $item) {
            $origin_account = Account::find($item->origin_account);
            $destination_account = Account::find($item->destination_account);

            $model = [
                "id" => $item->id,
                "amount" => $item->amount,
                "origin_account" => $origin_account->account_number,
                "destination_account" => $destination_account->account_number,
                "created_at" => $item->created_at,
                "state" => $state,
            ];
            array_push($response, $model);
        }

        return $response;
    }

    public function list()
    {
        try {

            $accounts = DB::table('accounts')->select('*')->where('user_id', Auth::id())->get();

            $transactions = [];
            $count = count($accounts);
            foreach ($accounts as $account) {
                $out_transactions = DB::table('transactions')->select('*')->where('origin_account', $account->id)->get();
                $input_transactions = DB::table('transactions')->select('*')->Where('destination_account', $account->id)->get();

                $transactions = array_merge($transactions, $this->GetTransactions($out_transactions, false));
                $transactions = array_merge($transactions, $this->GetTransactions($input_transactions, true));
            }

            return $this->SendResponse($transactions, "Success");
        } catch (Exception $ex) {
            return $this->SendError($ex, $ex->getMessage(), 500);
        }
    }

    public function index()
    {
        try {
            $accounts = DB::table('accounts')->select('*')->where('user_id', Auth::id())->get();
            $count = count($accounts);
            return view("transactional.list", ["count" => $count]);
        } catch (Exception $ex) {
            return view("error", ["error" => $ex]);;
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'origin_account' => 'required|numeric',
                'destination_account' => 'required|numeric',
                'amount' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->SendError($validator, $validator->errors(), 400);
            }
            // reglas de negocio
            $origin_account_number =  $request->input('origin_account');
            $destination_account_number =  $request->input('destination_account');
            $amount =  $request->input('amount');

            if ($origin_account_number == $destination_account_number) {
                return $this->SendError("Is the same account, isn´t posible make transaction", [], 400);
            }

            if ($amount < 1000) {
                return $this->SendError("The minimum amount to make the transfer is 1000", [], 400);
            }

            $origin_account = $this->AccountController->find($origin_account_number);
            $destination_account = $this->AccountController->find($destination_account_number);

            if ($origin_account->user_id != Auth::id()) {
                return $this->SendError("Invalid account", [], 400);
            }

            if (!$origin_account->state) {
                return $this->SendError("Your account is inactive", [], 400);
            }

            if (!$destination_account->state) {
                return $this->SendError("Destination account is inactive", [], 400);
            }


            if ($origin_account->amount < $amount) {
                return $this->SendError("Insufficient funds", [], 400);
            }

            Transaction::create([
                'amount' => $amount,
                'origin_account' => $origin_account->id,
                'destination_account' => $destination_account->id,
                'state' => true
            ]);
            $this->AccountController->updateAmount($origin_account->id, $origin_account->amount - $amount);
            $this->AccountController->updateAmount($destination_account->id, $destination_account->amount + $amount);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return $this->SendError($ex, $ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
