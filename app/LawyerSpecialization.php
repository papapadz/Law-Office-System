<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerSpecialization extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','specialization_id'];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
