<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprise';
    protected $primaryKey = 'enid';

    protected $fillable = [

        'enid',
        'enname',
        'enaddress1',
        'enaddress2',
        'encity',
        'encounty',
        'enpostcode',
        'encountry',
        'entelno',
        'enemailcomms',
        'enemailaccounts',
        'endiscount',
        'enquestaimanager',
        'encreatedby',
        'encreatedon',
        'enupdatedby',
        'enupdatedon',
        'enlastrefno',
        'entype',
        'enlink',
        'enenabled',
    ];
}
