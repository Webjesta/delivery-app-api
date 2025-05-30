<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Customer;
use App\Models\Seller;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // either seller or customer
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * Check if the user is a customer AND has an associated customer profile.
     * This is the recommended robust check.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        // Check if the role column is 'customer' AND if the customer relationship exists.
        return $this->role === 'customer' && $this->customer !== null;
    }

    /**
     * Check if the user is a seller AND has an associated seller profile.
     *
     * @return bool
     */
    public function isSeller(): bool
    {
        // Check if the role column is 'seller' AND if the seller relationship exists.
        return $this->role === 'seller' && $this->seller !== null;
    }
}
