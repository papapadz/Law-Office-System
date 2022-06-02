<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Feedback extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function queries()
    {
        return $this->belongsTo(Query::class, 'query_id', 'id');
    }
}
