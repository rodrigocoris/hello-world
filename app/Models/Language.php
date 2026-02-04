<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    
    protected $fillable = ['language', 'file_extension'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'language', 'language');
    }
}