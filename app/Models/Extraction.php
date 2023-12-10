<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraction extends Model
{
    use HasFactory;
    protected $table = 'extraction';

    protected $fillable = [
        'PID',
        'Date',
        'BMI',
        'Resting_BP',
        'Peak_BP',
    ];
}
