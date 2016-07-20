<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joke extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'titleSlug',
        'file',
    ];

    protected $validationRules = [
        'title' => 'required|unique:jokes|max:255',
        'file' => 'required',
    ];

    public function getValidationRules(){
        return $this->validationRules;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'titleSlug';
    }
}
