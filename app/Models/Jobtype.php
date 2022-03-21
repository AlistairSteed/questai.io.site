<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\PermittedCampaignsScope;
use App\Scopes\PermittedUserAccessScope;

class Jobtype extends Model
{
    use HasFactory;

    protected $table = 'jobtype';
    protected $primaryKey = 'jtid';

    protected $fillable = [

        'jtid',
        'jtdesc',
        'jtsearch',
        'jtadgroup',
        'jtvideo',

    ];
}
