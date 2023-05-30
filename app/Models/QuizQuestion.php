<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'quiz_questions';

    protected $fillable = ['quiz_id','question_id'];
}
