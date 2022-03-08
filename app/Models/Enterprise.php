<?php

namespace App\Models;

use App\Scopes\PermittedClientsScope;
use App\Support\Traits\EncryptedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Enterprise extends Model
{
    use HasFactory, EncryptedModel;

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
