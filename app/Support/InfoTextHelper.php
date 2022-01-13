<?php

namespace App\Support;

use App\Models\Infotext;

class InfoTextHelper
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public static $infoTextItems;

    public function __construct()
    {
        static::boot();
    }

    public static function boot()
    {
        if (!static::$infoTextItems) {
            static::$infoTextItems = Infotext::where('enterprise_id', enterpriseId())->get();
        }
    }

    public function get($name)
    {
        return optional(static::$infoTextItems->first(function($item) use ($name) {
            return $item->field_name === $name;
        }))->field_text;
    }
}