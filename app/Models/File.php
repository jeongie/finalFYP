<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    use HasFactory;
    protected $table = 'files';

    protected $fillable = [
        'user_id',
        'PID',
        'name',
        'type',
        'size',
        'path',
        'is_new',
        'tb_extract',

    ];

    use HasFactory;

    
}