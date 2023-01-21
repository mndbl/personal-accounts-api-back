<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\API\BaseController;
use App\Models\Data\Register;
use App\Models\Settings\Account;
use App\Models\Settings\AccountCategorie;
use Illuminate\Http\Request;

class ConsultController extends BaseController
{

    /**
     * Consult the all resources from storage.
     *
     * @param  \App\Models\Data\Register  $register
     * @return \Illuminate\Http\Request
     */
    public function account_index(Request $request)
    {

        $accounts = Account::with(['registers_deb', 'registers_cre', 'account_categorie'])
        ->get();
        return $this->sendResponse($accounts, 'Data');
    }
    /**
     * Consult the specified resource from storage.
     *
     * @param  \App\Models\Data\Register  $register
     * @return \Illuminate\Http\Request
     */
    public function account_show($id)
    {
        $account = Account::with(['registers_deb', 'registers_cre', 'account_categorie'])->find($id);
        if (!$account) {
            return $this->sendError('Not find account', ['error' => 'Not find account'], 201);
        }

        return $this->sendResponse($account, 'Result');
    }
}
