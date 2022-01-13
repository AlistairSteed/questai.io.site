<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    protected $table = 'function';
    protected $primaryKey = 'fuid';

    protected $fillable = [
        'fuid',
        'fudesc',
        'fusrid',
    ];
}
