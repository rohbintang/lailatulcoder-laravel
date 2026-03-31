<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'stock',
        'discount',
        'image',
        'is_active',
        'is_featured',
        'category_id',
        'seller_id',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active'      => 'boolean',
        'is_featured'    => 'boolean',
    ];

    // === RELASI ===
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function cartusers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cart_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // === SCOPES ===
    public function scopeActive(Builder $q): void
    {
        $q->where('is_active', true);
    }

    public function scopeInStock(Builder $q): void
    {
        $q->where('stock', '>', 0);
    }

    public function scopeFeatured(Builder $q): void
    {
        $q->where('is_featured', true);
    }

    public function scopeSearch(Builder $q, ?string $keyword): void
    {
        if ($keyword) {
            $q->where(fn($sq) =>
                $sq->where('name', 'like', "%{$keyword}%")
                   ->orWhere('description', 'like', "%{$keyword}%")
            );
        }
    }

    public function scopeByCategory(Builder $q, ?string $slug): void
    {
        if ($slug) {
            $q->whereHas('category', fn($sq) => $sq->where('slug', $slug));
        }
    }

    public function scopePriceRange(Builder $q, ?int $min, ?int $max): void
    {
        if ($min) {
            $q->where('price', '>=', $min);
        }
        if ($max) {
            $q->where('price', '<=', $max);
        }
    }

    public function scopeSortBy(Builder $q, string $sort): void
    {
        match($sort) {
            'price_low'  => $q->orderBy('price', 'asc'),
            'price_high' => $q->orderBy('price', 'desc'),
            'popular'    => $q->withCount('orderItems')->orderByDesc('order_items_count'),
            default      => $q->latest(),
        };
    }

    // === ACCESSORS ===
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn($v, $a) => 'Rp ' . number_format($a['price'], 0, ',', '.')
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($v, $a) => $a['image']
                ? Storage::url($a['image'])
                : asset('images/placeholder.jpg')
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value),
            set: fn(string $value) => trim($value),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => \Illuminate\Support\Str::slug($value),
        );
    }

    // === LIFECYCLE HOOKS ===
    protected static function booted(): void
    {
        static::addGlobalScope('active', fn(Builder $q) => $q->where('is_active', true));

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name)
                    . '-' . uniqid();
            }
        });

        static::deleting(function (Product $product) {
            \Illuminate\Support\Facades\Log::info('Product deleted', [
                'id'     => $product->id,
                'name'   => $product->name,
                'by'     => auth()->id(),
            ]);
        });

        static::forceDeleting(function (Product $product) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::delete($product->image);
            }
        });
    }

    // === HELPERS ===
    public function isOwnedBy(User $user): bool
    {
        return $this->seller_id === $user->id;
    }
}
