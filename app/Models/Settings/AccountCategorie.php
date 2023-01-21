<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'type'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
