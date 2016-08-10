<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Joke extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mandante',
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
        'paramFirstName',
        'paramNameSize',
        'paramNameColor',
        'paramNameX',
        'paramNameY',
    ];

    protected $validationRules = [
        'title' => 'required|max:255',
        'file' => 'required',
    ];

    protected $updateValidationRules = [
        'title' => 'required|max:255',
    ];

    public function getValidationRules(){
        return $this->validationRules;
    }
    public function getUpdateValidationRules(){
        return $this->updateValidationRules;
    }

    public function getFilteredDescriptionAttribute()
    {

        if (isset(Auth::user()->name)) {
            if ($this->attributes['paramFirstName']) {
                $aux = explode(' ', Auth::user()->name);
                $name = $aux[0];
            } else {
                $name = Auth::user()->name;
            }
            $desc = str_replace('#nome',$name ,$this->attributes['description']);
        }
        else $desc = $this->attributes['description'];
        return $desc;
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
