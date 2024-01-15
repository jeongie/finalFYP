<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraction extends Model
{
    use HasFactory;
    protected $table = 'extraction';

    protected $fillable = [
        'user_id','PID','age',
        'DM','dyslipi',
        'IHD','gender',
        'cabg',
        'hb1ac',
        'ef','Rest HR','Peak HR',
        'HR reserve', 'HR recovery',
        'hypertension',
        'cholestrol',
        'smoking',
        'alcohol',
        'diet',
        'bmi',
        'Rest BP',
        'Peak BP',
        'METS',
    ];
}
