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
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'file6',
        'file7',
        'file8',
        'file9',
        'file10',
        'file11',
        'file12',
        'file13',
        'file14',
        'file15',
        'paramProfileImageSize',
        'paramProfileImageX',
        'paramProfileImageY',
        'paramName',
        'paramNameSize',
        'paramNameColor',
        'paramNameX',
        'paramNameY',
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
