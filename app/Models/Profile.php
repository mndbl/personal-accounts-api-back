<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'mid_name',
        'last_name',
        'adress',
        'adress2',
        'mobile_phone',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
