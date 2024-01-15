<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Register;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;

class HistoricController extends Controller
{
    public function registerLastYear()
    {
        $registerToReset = [];
        $accounts = Account::with('account_categorie')->get();
        $registersLastYear = Register::with(['account_deb', 'account_cre'])->where('date', '<', '2024/01/01')->get();
        $accountsStatementofIncomes = [];
        foreach ($accounts as $acc) {
            if ($acc->account_categorie->type === 'statement of incomes') {
                array_push($accountsStatementofIncomes, $acc);
            }
        }
        return response()->json($accountsStatementofIncomes);
    }

    public function copyRegister(){
        $registers = Register::with(['account_deb', 'account_cre'])->where('date', '<', '2024/01/01')->get();
        $registerExternalDB= DB::connection('mysql2')->table('registers')->get();
        $registertoCopy = [];
        // foreach ($registers as $reg) {
        //     if ($reg->account_categorie->type === 'balance sheet') {
        //         array_push($registertoCopy, $reg);
        //     }
        // }
        return response()->json($registerExternalDB);
    }
}
