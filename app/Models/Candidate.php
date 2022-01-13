<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidate';
    protected $primaryKey = 'caid';
    public $timestamps = false;

    protected $fillable = [
        'caid',
        'cacaid',
        'caenterpriseid',
        'caclientid',
        'calastname',
        'cafirstnames',
        'caapplicationstatus',
        'careason',
        'cafinalstatus',
        'casrcandidateid',
        'caercandidateid',
        'cactcandidateid',
        'casource',
        'caemail',
        'caappdate',
    ];

    protected $appends = ['app_status', 'final_status_class', 'final_status'];


    public function getAppStatusAttribute()
    {
        if($this->caapplicationstatus == 0)
            $color = 'grey';
        elseif($this->caapplicationstatus == 1)
            $color = 'green';
        elseif($this->caapplicationstatus == 5)
            $color = 'amber';
        else
            $color = 'red';

        return $color;
    }

    public function getFinalStatusClassAttribute()
    {
        if($this->cafinalstatus == 00 || $this->cafinalstatus == 0)
            $color = 'bg-grey';
        elseif($this->cafinalstatus == 10 || $this->cafinalstatus == 20)
            $color = 'bg-green';
        elseif($this->cafinalstatus == 30 || $this->cafinalstatus == 35)
            $color = 'bg-amber';
        else
            $color = 'bg-red';

        return $color;
    }

    public function attachmentProfile()
    {
        return $this->hasOne(Attachment::class, 'atcandidateid', 'caid')->where('attype', 10);
    }

    static public $campaign_final_statuses = [
        00 => 'Waiting decision',
        10 => 'Request to accept',
        20 => 'Accepted',
        30 => 'Request to reject good candidate',
        35 => 'Request to reject',
        40 => 'Rejected good candidate',
        45 => 'Rejected unsuitable candidate'
    ];

    public static function getCandidateFinalStatus($status = null)
    {
        if (!$status) {
            $status = 00;
        }
        return self::$campaign_final_statuses[$status];
    }

    public function getFinalStatusAttribute()
    {
        return $this->getCandidateFinalStatus($this->cafinalstatus);
    }

    public function attachments(){
    	return $this->hasMany('App\Models\Attachment','atcandidateid','caid');
    }
}
