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
        'fieldName',
        'latLong',
        'fieldCreationDate',
        'currentCrop'
    ];

}
