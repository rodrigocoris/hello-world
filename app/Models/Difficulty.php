<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    use HasFactory;

    protected $primaryKey = 'difficulty_id';
    protected $table = 'difficulties';
    protected $fillable = ['level'];

    public function exercise()
    {
        return $this->hasMany(Exercise::class, 'difficulty_id', 'difficulty_id');
    }
}
