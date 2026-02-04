<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';
    protected $fillable = ['module_id', 'lesson', 'hierarchy', 'description', 'updated_at', 'created_at',];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'module_id');
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id', 'lesson_id');
    }
}