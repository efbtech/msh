<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSessionQuestion extends Model
{
    use HasFactory;
    protected $table = 'exam_session_questions';
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // public function setUserAnswerAttribute($value)
    // {
    //     $this->attributes['user_answer'] = serialize($value);
    // }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // public function getUserAnswerAttribute($value)
    // {
    //     return unserialize($value);
    // }


}
