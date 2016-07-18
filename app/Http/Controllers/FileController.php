<?php

namespace App\Http\Controllers;

use ErpNET\FileManager\FileManager;
use Illuminate\Http\Request;

use App\Http\Requests;

class FileController extends Controller
{
    public function show($file, FileManager $fileManager){
        return $fileManager->loadImageFile($file, 'jokes');
    }
}
