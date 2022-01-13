<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infotext extends Model
{
    use HasFactory;

    protected $table = 'infotext';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
      'id',
      'enterprise_id',
      'field_name',
      'order',
      'filed_type',
      'field_text',
    ];
}
