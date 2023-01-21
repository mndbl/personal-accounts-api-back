<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Models\Settings\AccountCategorie;

class AccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Account::all()) < 1) {
            return $this->sendError('No accounts have been created yet', ['error' => 'Empty information.'], 201);
        }
        return $this->sendResponse(Account::with(['account_categorie', 'registers_deb', 'registers_cre'])->orderBy('name', 'asc')->get(), 'Accounts list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existData = Account::where('name', '=', $request->name)->first();
        if ($existData) {
            return $this->sendError('Name "' . $request->name . '" is duplicated', ['error', 'Name is duplicated'], 500);
        }
        $validator = Validator::make($request->all(), [
            'account_categorie_id' => 'required|numeric',
            'name' => 'required',
            'initial_deb_balance' => 'required|numeric',
            'initial_cre_balance' => 'required|numeric',
            'cutoff_date' => 'required|date',
        ]);
        $validCategorie = AccountCategorie::find($request->account_categorie_id);
        if (!$validCategorie) {
            return $this->sendError('The category does not exist', ['error' => 'The category does not exist'], 201);
        }
        if ($validator->fails()) {
            return $this->sendError('You must add all the account information.', $validator->errors(), 201);
        }

        $newAccount = Account::create($request->all());
        return $this->sendResponse($newAccount, 'Successfully registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::with(['account_categorie', 'registers_deb', 'registers_cre'])->find($id);
        if (!$account) {
            return $this->sendError('Not found register', ['error' => 'Not found register'], 201);
        }

        return $this->sendResponse($account, 'Result');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $accountToUpdate = Account::with('account_categorie')->find($id);
        if (!$accountToUpdate) {
            return $this->sendError('Not found register', ['error' => 'Not found register'], 201);
        }

        $validator = Validator::make($request->all(), [
            'account_categorie_id' => 'required|numeric',
            'name' => 'required',
            'initial_deb_balance' => 'required|numeric',
            'initial_cre_balance' => 'required|numeric',
            'cutoff_date' => 'required|date',
        ]);
        $validCategorie = AccountCategorie::find($request->account_categorie_id);
        if (!$validCategorie) {
            return $this->sendError('The category does not exist', ['error' => 'The category does not exist'], 201);
        }
        if ($validator->fails()) {
            return $this->sendError('You must add all the account information.', $validator->errors(), 201);
        }
        $accountToUpdate->account_categorie_id = $request->account_categorie_id;
        $accountToUpdate->name = $request->name;
        $accountToUpdate->initial_deb_balance = $request->initial_deb_balance;
        $accountToUpdate->initial_cre_balance = $request->initial_cre_balance;
        $accountToUpdate->cutoff_date = $request->cutoff_date;

        $accountToUpdate->save();

        return $this->sendResponse($accountToUpdate, 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accountToDelete = Account::find($id);
        if (!$accountToDelete) {
            return $this->sendError('Not found register', ['error' => 'Not found register'], 201);
        }
        $accountToDelete->delete();
        return $this->sendResponse($accountToDelete, 'Successfully deleted');
    }
}
