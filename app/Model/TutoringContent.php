<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// https://laravel.com/docs/6.x/eloquent
class TutoringContent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tutoring_content';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
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
