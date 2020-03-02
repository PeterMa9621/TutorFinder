<?php

namespace App\Model\Tutor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// https://laravel.com/docs/5.8/eloquent
class CanTutor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'can_tutor';

    protected $primaryKey = null;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_id', 'course'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
