<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\API\BaseController;
use App\Models\Data\Register;
use App\Models\Settings\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registers = Register::with(['account_deb', 'account_cre', 'account_deb.account_categorie', 'account_cre.account_categorie'])
            ->orderBy('date', 'desc')->get();
        if (count($registers) < 1) {
            return $this->sendError('No registers have been created yet', ['error' => 'Empty information'], 201);
        }
        return $this->sendResponse($registers, 'Data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'account_id_deb' => 'required|numeric',
            'account_id_cre' => 'required|numeric',
            'description' => 'required|min:3',
            'amount' => 'required|numeric'
        ]);
        $account_deb = Account::find($request->account_id_deb);
        $account_cre = Account::find($request->account_id_cre);
        if (!$account_deb) {
            return $this->sendError('The account debit id does not exist', ['error' => 'The account debit id does not exist'], 201);
        }
        if (!$account_cre) {
            return $this->sendError('The account credit id does not exist', ['error' => 'The account credit id does not exist'], 201);
        }

        if ($account_cre->id === $account_deb->id) {
            return $this->sendError('The account debit and credit must be different', ['error' => 'The account debit and credit must be different']);
        }

        if ($validator->fails()) {
            return $this->sendError('You must add all the information.', $validator->errors(), 201);
        }

        $newRegister = Register::create($request->all());

        return $this->sendResponse($newRegister, 'Register created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Data\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $register = Register::with(['account_deb', 'account_cre'])->find($id);
        if (!$register) {
            return $this->sendError('Record not found', ['error' => 'Record not found'], 201);
        }

        return $this->sendResponse($register, 'Result');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Data\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $register = Register::find($id);
        if (!$register) {
            return $this->sendError('Record not found', ['error' => 'Record not found'], 201);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'account_id_deb' => 'required|numeric',
            'account_id_cre' => 'required|numeric',
            'description' => 'required|min:3',
            'amount' => 'required|numeric'
        ]);
        $account_deb = Account::find($request->account_id_deb);
        $account_cre = Account::find($request->account_id_cre);
        if (!$account_deb) {
            return $this->sendError('The account debit id does not exist', ['error' => 'The account debit id does not exist'], 201);
        }
        if (!$account_cre) {
            return $this->sendError('The account credit id does not exist', ['error' => 'The account credit id does not exist'], 201);
        }

        if ($account_cre->id === $account_deb->id) {
            return $this->sendError('The account debit and credit must be different', ['error' => 'The account debit and credit must be different']);
        }

        if ($validator->fails()) {
            return $this->sendError('You must add all the information.', $validator->errors(), 201);
        }
        $register->update($request->all());
        return $this->sendResponse($register, 'Register updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Data\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register = Register::find($id);
        if (!$register) {
            return $this->sendError('Record not found', ['error' => 'Record not found'], 201);
        }
        $register->delete();
        return $this->sendResponse($register, 'Successfully deleted');
    }
}
