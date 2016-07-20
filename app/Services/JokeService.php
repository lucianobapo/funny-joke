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

    public function dataModelInstance()
    {
        return $this->joke;
    }
}