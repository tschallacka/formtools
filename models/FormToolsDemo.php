<?php namespace Tschallacka\FormTools\Models;

use Model;

/**
 * FormToolsDemo Model
 */
class FormToolsDemo extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tschallacka_formtools_form_tools_demos';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'options',
        'color',
    ];
    
    public $jsonable = [
        'options',
    ]; 
    
    public $rules = [
        'name' => 'required',
    ];
    
    public function getOptionsOptions() 
    {
        return [
            0 => 'tschallacka.formtools::lang.demo_model.option_descriptions.0',
            1 => 'tschallacka.formtools::lang.demo_model.option_descriptions.1',
            2 => 'tschallacka.formtools::lang.demo_model.option_descriptions.2',
            3 => 'tschallacka.formtools::lang.demo_model.option_descriptions.3',
            4 => 'tschallacka.formtools::lang.demo_model.option_descriptions.4',
            5 => 'tschallacka.formtools::lang.demo_model.option_descriptions.5',
            6 => 'tschallacka.formtools::lang.demo_model.option_descriptions.6',
            7 => 'tschallacka.formtools::lang.demo_model.option_descriptions.7',
            8 => 'tschallacka.formtools::lang.demo_model.option_descriptions.8',
            9 => 'tschallacka.formtools::lang.demo_model.option_descriptions.9',
        ];  
    }

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
