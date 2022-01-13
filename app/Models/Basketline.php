<?php

namespace App\Models;

use App\Models\Basket;
use App\Models\Product;
use App\Models\Candidate;
use App\Support\Traits\EncryptedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Basketline extends Model
{
    use HasFactory, EncryptedModel;
    protected $table = 'basketline';
    protected $primaryKey = 'blif';
    public $timestamps = false;

    protected $fillable = [
        'blif',
        'blbasketid',
        'blcampaignid',
        'blcandidateid',
        'blproductid',
        'blprice',
        'blprocessed',
    ];

    public function basket(){
        return $this->belongsTo(Basket::class, 'blbasketid');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'blproductid');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'blcandidateid');
    }
}
