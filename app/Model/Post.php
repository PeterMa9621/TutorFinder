<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// https://laravel.com/docs/5.8/eloquent
class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['closed_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poster', 'tutoring_content', 'course', 'when', 'closed_at'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = 'user_id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    /*
    protected $attributes = [
        'content' => '',
        'poster' => ''
    ];
    */
}
