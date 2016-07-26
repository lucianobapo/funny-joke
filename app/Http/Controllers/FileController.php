<?php

namespace App\Http\Controllers;

use ErpNET\FileManager\FileManager;
use Illuminate\Http\Request;

use App\Http\Requests;

class FileController extends Controller
{
    private $fileManager;

    public function __construct(FileManager $fileManager){
        $this->fileManager = $fileManager;
    }

    public function show($file){
        return $this->fileManager->loadImageFile($file, 'jokes');
    }

    public function showJoke($id, $params = [], $file){
        if (is_string($params)) $params = unserialize(urldecode($params));
//        dd($params);
        return $this->fileManager->insertSocialProfileWithBgImage($file, $id, $params, 'jokes')->response();
    }

    public function fit($size, $file){
        return $this->fileManager->loadImageFileFit($size, $file, 'jokes');
    }
}
