<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'mark' ,
        'model' ,
        'generation' ,
        'year' ,
        'run' ,
        'color' ,
        'body-type' ,
        'engine-type' ,
        'transmission' ,
        'gear-type',
        'generation_id',
        'deleted_at',
    ];
}
