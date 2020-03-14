<?php

namespace App\Model\Tutor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tutor_comment';

    //protected $primaryKey = null;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_id', 'user_id', 'content', 'score'
    ];
}
