<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getPaymentUploud($filename)
    {
        // dd($filename);
        $path = 'payments/' . $filename;
        $file = Storage::disk('local')->get($path);
        // dd(response($file));
        return response($file);
    }
}
