<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $fillable = ['user_id', 'amount', 'address', 'email', 'status', 'details', 'ordered_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['ordered_at' => 'date'];
    
    /**
     * Relationship between @\App\Models\Order and @\App\Models\Products
     *
     * @returns BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_product_id', 'order_id');
    }
}
