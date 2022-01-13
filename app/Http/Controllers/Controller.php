<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile($inputName, $storeDir)
    {

        try {
            if (!request()->hasFile($inputName)) {
                return ['status' => false, 'message' => 'File is required'];
            }

            $file = request()->file($inputName);
            $image = rand(10000, 99999) . '_' . date('Y-m-d_H_i_s') . '.' . $file->getClientOriginalExtension();
            $path = request()->{$inputName}->storeAs($storeDir, $image);
            $path = str_replace('public/', '', $path);

            return ['status' => true, 'message' => 'File uploaded', 'path' => $path];

        } catch (\Exception $e) {

            Log::error('File upload error:'.$e->getMessage());
            return ['status' => false, 'message' => 'File upload Failed'];
        }
    }
}
