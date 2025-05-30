<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;  // Import User model
use App\Models\Order; // Import Order model
use Illuminate\Notifications\Notifiable;


/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUserId($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use Notifiable;
    
    protected $fillable = [
        'user_id',
        'address',
        // Add any other fillable attributes for your Customer model
    ];

    // Define the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the orders relationship
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}