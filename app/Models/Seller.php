<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // Import User model
use App\Models\Product; // Import Product model
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $shop_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereShopName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUserId($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    use Notifiable;
    
    protected $fillable = [
        'user_id',
        'shop_name',
        // Add any other fillable attributes for your Seller model
    ];

    // Define the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the products relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}