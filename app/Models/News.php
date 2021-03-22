<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title','url', 'descriptions', 'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
