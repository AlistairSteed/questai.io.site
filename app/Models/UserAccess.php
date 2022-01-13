<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;

    protected $table = 'useraccess';
    protected $primaryKey = 'uaid';
    public $timestamps = false;

    protected $fillable = [
      'uaid',
      'uausid',
      'uaenterpriseid',
      'uaclientid',
      'uacampaignid',
      'uaaccess',
    ];
}
