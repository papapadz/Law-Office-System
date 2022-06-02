<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Lawyer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public function queries()
    {
        return $this->hasMany(Query::class);
    }
}
