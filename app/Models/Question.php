<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = ['code','question','options','is_active','ans_weight','default_time','question_type_id','question_weight','formula'];

    

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
        'ans_weight' => 'array',
        'question_weight' => 'float',
        'formula' =>'array',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->attributes['code'] = 'que_' . Str::random(11);
        });
    }


     /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // public function setAnsWeightAttribute($value)
    // {
    //     $this->attributes['ans_weight'] = serialize($value);
    // }


        /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // public function getOptionsAttribute($value)
    // {
    //     return unserialize($value);
    // }
}
