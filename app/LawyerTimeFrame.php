<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerTimeFrame extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id','from','to'];
}
