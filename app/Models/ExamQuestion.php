<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'exam_questions';

    protected $fillable = ['exam_id','question_id','exam_section_id'];

    public function questions(){
        return $this->hasOne(Question::class,'id','question_id');
    }

}
