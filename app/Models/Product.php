<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

/**
 * App\Models\Product
 *
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @property string $sku
 * @property float $price
 * @property float $weight
 * @property string $stock
 * @property string $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $pictures
 * @property-read int|null $pictures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $subcategories
 * @property-read int|null $subcategories_count
 * @property string $name
 * @property int $status
 * @property string $description
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAllTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAnyTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAnyTagsOfAnyType($tags)
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, HasTags;
    
    protected $fillable = [
        'sku',
        'name',
        'weight',
        'description',
        'stock',
        'status',
        'price'
    ];
    
    /**
     * Relation of product and images
     *
     * @returns HasMany
     */
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class, 'product_id');
    }
    
    /**
     * Relationship between Category and Products
     *
     * @return BelongsToMany Category
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    
    /**
     * Relationship between SubCategories and Products
     *
     * @return BelongsToMany SubCategories
     */
    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_sub_category', 'product_id', 'sub_category_id');
    }
}
