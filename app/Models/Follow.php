<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable= [
        'user_id', 'company_id'
    ];
    protected $casts = [
        'accepted_at' => 'datetime',
    ];
}
