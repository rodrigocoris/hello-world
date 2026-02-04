<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'plan_id',
        'paypal_subscription_id',
        'paypal_plan_id',
        'status',
        'start_at',
        'finish_at',
        'end_at',
        'status_update_time',
        'last_payment_amount',
        'last_payment_time',
    ];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship with the SubscriptionPlan model
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'plan_id');
    }
}
