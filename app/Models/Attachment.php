<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';
    protected $primaryKey = 'atid';

    protected $fillable = [
    'atid',
    'atcandidateid',
    'attype',
    'atsubtype',
    'atstatus',
    'atlink',
    'atscore',
    'atscoresort',
    'atscoreset',
    'atexpire',
    'attitle',
    'atcampaignid',
    'atcreated',
    'atcompleted',
    ];

    protected $appends = [
        'at_link_url',
    ];

    public function getAtLinkUrlAttribute()
    {
        if (!$this->atlink){
            return;
        }

        if (Str::startsWith($this->atlink, 'http')) {
            return $this->atlink;
        } else {
            // return url('attachment/file/'.$this->atlink);
            return Storage::disk('s3')->temporaryUrl($this->atlink,now()->addMinutes(5));
        }
    }
}
