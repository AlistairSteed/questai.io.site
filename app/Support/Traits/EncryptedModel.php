<?php

namespace App\Support\Traits;

trait EncryptedModel {

    public static function findOrFailByEncryptedId($encryptedId)
    {
        $id = base64_decode($encryptedId);

        return self::findOrFail($id);
    }

    public function getEncryptedIdAttribute()
    {
        return base64_encode($this->{$this->primaryKey});
    }
}