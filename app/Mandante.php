<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mandante extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mandante',
        'siteName',
        'jokeName',
    ];

    protected $validationRules = [
        'mandante' => 'required',
        'siteName' => 'required',
        'jokeName' => 'required',
    ];

    public function getValidationRules(){
        return $this->validationRules;
    }
}
