<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Query extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;
	
	protected $fillable = [];

	public function lawyer()
	{
		return $this->belongsTo(User::class, 'lawyer_id', 'id');
	}

	public function client()
	{
		return $this->belongsTo(User::class, 'client_id', 'id');
	}
	public function specialization() {
		return $this->hasOne(Specialization::class,'id','subject');
	}
}
