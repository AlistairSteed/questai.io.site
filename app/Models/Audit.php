<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';
    protected $primaryKey = 'auid';
    public $timestamps = false;

    protected $fillable = [
        'auid',
        'auenterpriseid ',
        'auclientid ',
        'aucampaignid ',
        'audatetime ',
        'autype ',
        'audetails ',
    ];

    public function Campaign(){
        return $this->hasOne(Campaign::class, 'caid', 'aucampaignid');
    }
}
