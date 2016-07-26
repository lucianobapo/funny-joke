<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 23/06/16
 * Time: 02:17
 */

namespace App\Services;

use App\Joke;

class JokeService
{
    protected $joke;

    public function __construct(Joke $joke){
        $this->joke = $joke;
    }

    public function getAll(){
        return $this->joke->all();
    }

    public function getFillableFields()
    {
        return $this->joke->getFillable();
    }

    public function getValidationRules()
    {
        return $this->joke->getValidationRules();
    }
    public function getUpdateValidationRules()
    {
        return $this->joke->getUpdateValidationRules();
    }

    public function dataModelInstance()
    {
        return $this->joke;
    }

    public function saveOrFail($fields)
    {
        $filteredFields = [];
        foreach ($fields as $key => $value) {
            if (!empty($fields[$key])) $filteredFields[$key] = $value;
        }

        if(!isset($filteredFields['mandante']))
            $filteredFields['mandante'] = config('ilhanet.defaultMandante');

        $model = $this->joke->newInstance($filteredFields);
        return $model->saveOrFail();
    }

    /**
     * @param \App\Joke $joke
     * @param $fields
     * @return mixed
     */
    public function updateOrFail($joke, $fields)
    {
        return $joke->update($fields);
    }
}