<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use App\Support\Traits\EncryptedModel;
use App\Scopes\PermittedCampaignsScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\PermittedUserAccessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, EncryptedModel;

    protected $table = 'campaign';
    protected $primaryKey = 'caid';
    public $timestamps = false;

    protected $fillable = [
        'caid',
        'caenterpriseid',
        'caclientid',
        'castatus',
        'caaddress1',
        'caaddress2',
        'cacity',
        'cacounty',
        'capostcode',
        'cacountryid',
        'catelno',
        'cajobtitle',
        'cajobdesc',
        'casalaryfrom',
        'casalaryto',
        'caote',
        'caessentialqual',
        'cadesirablequal',
        'caadditional',
        'cajobvideo1',
        'cajobvidoe2',
        'caindustryid',
        'cajobtypeid',
        'caemploytypeid',
        'cafuntionid',
        'caexperienceid',
        'caprivate',
        'caremote',
        'calink',
        'cadate',
        'caapprovedby',
        'caapprovedon',
        'caadvertenddate',
        'caenddate',
        'caqty',
        'cafound',
        'caaiallowed',
        'caaicount',
        'caextendedby',
        'caextendedon',
        'caaiwarning',
        'casrjobid',
        'caeasyrecruecampaignid',
        'cacompdesc',
        'cacreatedby',
        'cacreatedon',
        'caupdatedby',
        'caupdatedon',
    ];

    static public $campaign_statuses = [
        0 => 'Created',
        1 => 'Purchased',
        2 => 'Amended',
        3 => 'Waiting for approval',
        4 => 'approved',
        5 => 'published',
        7 => 'Advert closed',
        8 => 'Closing',
        9 => 'Closed',
    ];

    public static function getCampaignStatus($status = null)
    {
        if (!$status) {
            $status = 0;
        }
        return self::$campaign_statuses[$status];
    }

    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new PermittedCampaignsScope);
    }
}
