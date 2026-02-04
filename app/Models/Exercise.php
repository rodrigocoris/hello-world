<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $primaryKey = 'exercise_id';
    protected $table = 'exercises';
    protected $fillable = ['exercise_token', 'lesson_id', 'exercise', 'status', 'description', 'difficulty_id', 'hierarchy', 'body_code', 'test_cases', 'updated_at', 'created_at',];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'lesson_id');
    }

    public function difficulties()
    {
        return $this->belongsTo(Difficulty::class, 'difficulty_id', 'difficulty_id');
    }
}
