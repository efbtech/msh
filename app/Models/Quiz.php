<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

   

    protected $table = 'quizzes';
    

    protected $fillable = ['title','code','questions','description','total_questions','total_duration','total_marks','is_paid','is_active']; 

    
    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->attributes['code'] = 'quiz_' . Str::random(11);
        });
    }
}
