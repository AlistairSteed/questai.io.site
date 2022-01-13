<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $primaryKey = 'neid';
    public $timestamps = false;

    protected $fillable = [
      'neid',
      'neenterpriseid',
      'nedate',
      'netitle',
      'neimagelink',
      'nearticlelink',
    ];

    protected $appends = ['news_date', 'news_image_url'];

    public function getNewsDateAttribute()
    {
        return Carbon::parse($this->nedate)->format('Y-m-d');
    }

    public function getNewsImageUrlAttribute()
    {
        if ($this->neimagelink && Storage::disk('public')->exists($this->neimagelink)) {
            return asset('storage/' . $this->neimagelink);
        }
        return '';
    }

    
}
