<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $primaryKey = 'module_id';
    protected $fillable = ['token', 'language', 'module', 'hierarchy'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'module_id', 'module_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language', 'language');
    }

    public function progress()
    {
        return $this->hasMany(ModuleProgress::class, 'module_id', 'module_id');
    }
}
