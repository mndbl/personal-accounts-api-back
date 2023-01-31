<?php

namespace App\Models\Data;

use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Register extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date','user_id', 'account_id_deb','account_id_cre', 'description', 'amount'
    ];

    public function account_deb()
    {
        return $this->belongsTo(Account::class,'account_id_deb');
    }
    public function account_cre()
    {
        return $this->belongsTo(Account::class,'account_id_cre');
    }
}
