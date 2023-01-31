<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\API\BaseController;
use App\Models\Settings\AccountCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountCategorieController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountCategories = AccountCategorie::orderBy('name', 'asc')->where('user_id', Auth::user()->id)->get();
        if (count($accountCategories) < 1) {
            return $this->sendError('No account categories have been created yet', ['error' => 'Empty information'], 201);
        }
        return $this->sendResponse($accountCategories, 'List of account categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existData = AccountCategorie::where('name', '=', $request->name)->first();
        if ($existData) {
            return $this->sendError('Name "' . $request->name . '" is duplicated', ['error', 'Name is duplicated'], 500);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'type' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return $this->sendError('You must add all the information', $validator->errors(), 201);
        }
        $data = [
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'type' => $request->type
        ];

        $newAccountCategorie = AccountCategorie::create($data);
        return $this->sendResponse($newAccountCategorie, 'Succefully registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\AccountCategorie  $accountCategorie
     * @return \Illuminate\Http\Response
     */
    public function show(AccountCategorie $accountCategorie, $id)
    {

        $accountCategorie = AccountCategorie::with('accounts')->find($id);
        if (!$accountCategorie) {
            return $this->sendError('Account Categorie not found', ['error' => 'Not found'], 201);
        }

        return $this->sendResponse($accountCategorie, 'Result');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\AccountCategorie  $accountCategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:3',
            'type' => 'required|min:3'
        ]);

        $accountCategorie = AccountCategorie::find($id);
        if (!$accountCategorie) {
            return $this->sendError('Not found register', ['error' => 'Not found register'], 201);
        }
        if ($validator->fails()) {
            return $this->sendError('You must add all the information', $validator->errors(), 201);
        }

        $accountCategorie->user_id = Auth::user()->id;
        $accountCategorie->name = $request->name;
        $accountCategorie->type = $request->type;
        $accountCategorie->save();

        return $this->sendResponse($accountCategorie, 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\AccountCategorie  $accountCategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountCategorie $accountCategorie, $id)
    {
        $accountCategorie = AccountCategorie::find($id);
        if (!$accountCategorie) {
            return $this->sendError('Not found register', ['error' => 'Not found register'], 201);
        }
        $accountCategorie->delete();

        return $this->sendResponse($accountCategorie, 'Successfully deleted');
    }
}
