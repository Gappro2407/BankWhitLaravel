<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        try {

            $accounts = DB::table('accounts')->select('*')->where('user_id', Auth::id())->get();
            return $this->SendResponse($accounts, "Success");
        } catch (Exception $ex) {
            return $this->SendError($ex, $ex->getMessage(), 500);
        }
    }

    public function index()
    {
        //     try{

        //         $accounts = DB::table('accounts')->select('*')->where('user_id',Auth::id())->get();
        //         return $this->SendResponse($accounts, "Success");
        //     }
        //    catch(Exception $ex){
        //        return $this->SendError($ex, $ex->getMessage(), 500);
        //    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            Account::create([
                'amount' => 5000.00,
                'state' => true,
                'account_number' => Account::getUniqueAccount(),
                'user_id' => 1
            ]);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return null;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function find($account_number)
    {
        try {
            $account = DB::table('accounts')->select('*')->where('account_number', $account_number)->first();
            return $account;
            //throw new Exception("Error");
        } catch (Exception $ex) {
            return null;
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function updateAmount($id, $amount)
    {
        $account = Account::find($id);
        $account->amount = $amount;
        $account->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account, $id)
    {
        DB::beginTransaction();
        try {

            Account::destroy($id);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return null;
        }
    }
}
