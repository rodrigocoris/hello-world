<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = ['role_name'];

    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class, 'role_name', 'role_name');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function userSubscription()
    {
        return $this->hasMany(UserSubscription::class, 'role_id', 'role_id');
    }
}
