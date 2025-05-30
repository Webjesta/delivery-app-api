<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seller; // Import Seller model
use App\Models\Order;  // Import Order model (if product can have many orders)


/**
 * 
 *
 * @property int $id
 * @property int $seller_id
 * @property string $name
 * @property string|null $description
 * @property string $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Seller $seller
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'stock',
        // Add any other fillable attributes for your Product model
    ];

    // Define the seller relationship
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // If orders can have many products, or a product can be in many orders:
    // public function orders()
    // {
    //     return $this->hasMany(Order::class); // if an Order has one Product
    // }
}