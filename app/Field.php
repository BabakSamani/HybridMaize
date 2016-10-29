<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'field_name',
        'latitude',
        'longitude',
        'altitude',
        'area',
        'current_crop',
        'field_creation_date',
        'current_crop'
    ];
}
