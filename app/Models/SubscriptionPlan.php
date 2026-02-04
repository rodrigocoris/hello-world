<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_token', 'name', 'role_name', 'price', 'currency', 'frequency', 'description', 'status', 'benefits'];

    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_name', 'role_name');
    }
}
