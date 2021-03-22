<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boost_Record extends Model
{
    protected $fillable = [
        'company_id','days', 'end_date', 'admin_id', 'message'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
