<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';
    protected $primaryKey = 'coid';
    public $timestamps = false;

    protected $fillable = [
        'coid',
        'coenterpriseid',
        'coclientid',
        'cocampaignid',
        'cocandidateid',
        'codate',
        'couser',
        'cocomment',
    ];

    public function user(){
        return $this->hasOne(User::class, 'usid', 'couser');
    }
}
