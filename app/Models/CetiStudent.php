<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetiStudent extends Model
{
    use HasFactory;

    protected $table = 'ceti_students';
    
    protected $primaryKey = 'ceti_student_id';

    protected $fillable = ['user_id', 'register', 'name', 'institutional_mail', 'major', 'campus', 'education_level', 'group', 'level', 'shift'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
