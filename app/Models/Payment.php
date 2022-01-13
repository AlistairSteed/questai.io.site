<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $primaryKey = 'id';

    protected $fillable = [
    'id',
    'basket_id',
    'payment_response',
    'payment_status',
    'payment_type',
    ];
}
