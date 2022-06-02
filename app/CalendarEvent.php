<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CalendarEvent extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [];

    public function queries()
    {
        return $this->belongsTo(Query::class, 'query_id', 'id');
    }
}
