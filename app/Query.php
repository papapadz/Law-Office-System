<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Query extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	protected $fillable = [];

	public function lawyer()
	{
		return $this->belongsTo(User::class, 'lawyer_id', 'id');
	}

	public function client()
	{
		return $this->belongsTo(User::class, 'client_id', 'id');
	}
}
