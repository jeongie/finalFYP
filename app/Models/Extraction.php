<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraction extends Model
{
    use HasFactory;
    protected $table = 'extraction';

    protected $fillable = [
        'user_id','PID',
        'DM','dyslipi',
        'IHD',
        'cabg',
        'hb1ac',
        'ef','Rest HR',
        'hypertension',
        'cholestrol',
        'smoking',
        'alcohol',
        'bmi',
        'Rest BP',
        'Peak BP',
        'METS',
    ];
}
