<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title', 'type', 'for', 'user_id', 'description', 'status', 'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
