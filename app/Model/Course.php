<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// https://laravel.com/docs/6.x/eloquent
class Course extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'description', 'website'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    /*
    protected $attributes = [
        'description' => '',
        'website' => ''
    ];
    */

}
