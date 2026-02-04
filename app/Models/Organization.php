<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = ['organization_name', 'org_category', 'organization_email', 'location', 'description'];

    public function orgCategory()
    {
        return $this->belongsTo(OrgCategories::class, 'org_category', 'id');
    }
}
