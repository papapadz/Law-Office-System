<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Audit extends Model implements Auditable
{
     use \OwenIt\Auditing\Auditable;
     protected $fillable = ['name', 'description'];

      public function user()
    {
        return $this->belongsTo(User::class, 'user_number', 'id');
    }

    public function audit()
    {
        return $this->belongsTo(Admin::class, 'audits', 'id');
    }
}
