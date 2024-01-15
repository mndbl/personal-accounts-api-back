<?php

namespace App\Models\Settings;

use App\Models\Data\Register;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_categorie_id',
        'name',
        'initial_deb_balance',
        'initial_cre_balance',
        'cutoff_date',
    ];

    public function account_categorie()
    {
        return $this->belongsTo(AccountCategorie::class);
    }


    public function registers_deb()
    {
        return $this->hasMany(Register::class, 'account_id_deb');
    }
    public function registers_cre()
    {
        return $this->hasMany(Register::class, 'account_id_cre');
    }
}
