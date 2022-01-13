<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'said';

    protected $fillable = [
        'said',
        'sarefno',
        'saenterpriseid',
        'saclientid',
        'sacampaignid',
        'saservicetype',
        'sadatetime',
        'sapaymenttype',
        'sadesc',
        'sagrandtotal',
        'saapproveddate',
    ];

    static public $sales_payment_type = [
        00 => 'Credit card',
        10 => 'Direct debit',
        20 => 'Invoice',
    ];

    public static function getSalesPaymentType($status = null)
    {
        if (!$status) {
            $status = 0;
        }
        return self::$sales_payment_type[$status];
    }

    public function Client()
    {
        return $this->hasOne(Client::class, 'clid', 'saclientid');
    }
}
