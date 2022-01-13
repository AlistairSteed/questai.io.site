<?php

namespace App\Models;

use App\Scopes\PermittedClientsScope;
use App\Support\Traits\EncryptedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, EncryptedModel;

    protected $table = 'client';
    protected $primaryKey = 'clid';
    public $timestamps = false;

    protected $fillable = [
        'clid',
        'clenterpriseid',
        'clname',
        'claddress1',
        'claddress2',
        'clcity',
        'clcounty',
        'clpostcode',
        'clcountry',
        'cltelno',
        'clemail',
        'clvideo',
        'clcompanydesc',
        'clcreatedby',
        'cxlcreatedon',
        'clupdatedby',
        'clupdatedon',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new PermittedClientsScope);
    }
}
