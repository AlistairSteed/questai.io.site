<?php

namespace App\Models;

use App\Models\Basketline;
use App\Support\Traits\EncryptedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Basket extends Model
{
    use HasFactory, EncryptedModel;
    protected $table = 'basket';
    protected $primaryKey = 'baid';
    public $timestamps = false;

    protected $fillable = [
        'baid',
        'baenterpriseid',
        'baclientid',
        'bauserid',
        'badatestart',
        'bacomplete',
        'badatecomplete',
        'basalesid',
    ];

    protected $appends = [
        'total_amount'
    ];

    public function basketLines()
    {
        return $this->hasMany(Basketline::class, 'blbasketid');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'usid', 'bauserid');
    }

    public function total()
    {
        return $this->basketLines->reduce(function($total, $basketLine) {
            return $total + (float) $basketLine->blprice;
        }, 0);
    }

    public function getTotalAmountAttribute()
    {
        return $this->total();
    }
}
