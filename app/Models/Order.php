<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer; // Import Customer model
use App\Models\Product;  // Import Product model

/**
 * 
 *
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 * @property int $quantity
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Customer $customer
 * @property-read Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'status',
    ];

    // Define the customer relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Define the product relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}