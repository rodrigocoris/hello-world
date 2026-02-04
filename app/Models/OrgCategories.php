<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgCategories extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'org_category'
    ];

    public function organization(){
        return $this->hasMany(Organization::class, 'org_category', 'id'); 
    }
}
