<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 23/06/16
 * Time: 02:17
 */

namespace App\Services;

use App\Mandante;

class MandanteService
{
    protected $mandante;

    public function __construct(Mandante $mandante){
        $this->mandante = $mandante;
    }

    public function getAll(){
        return $this->mandante->all();
    }

    public function dataModelInstance()
    {
        return $this->mandante;
    }

    public function getFillableFields()
    {
        return $this->mandante->getFillable();
    }

    public function getValidationRules()
    {
        return $this->mandante->getValidationRules();
    }

    public function saveOrFail($fields)
    {
        $model = $this->mandante->newInstance($fields);
        return $model->saveOrFail();
    }

    public function getSiteName(){
        if(\Auth::guest()) return config('ilhanet.defaultSiteName');
        else {
            return $this->mandante->where(['mandante'=>\Auth::user()->mandante])->first()->siteName;
        }
    }
    public function getJokeName(){
        if(\Auth::guest()) return config('ilhanet.defaultJokeName');
        else {
            return $this->mandante->where(['mandante'=>\Auth::user()->mandante])->first()->jokeName;
        }
    }
}