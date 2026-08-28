<?php

namespace App\Models;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use Database\Factories\ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    /** @use HasFactory<ItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inventory_code',
        'serial_number',
        'name',
        'category_id',
        'brand',
        'model',
        'acquisition_year',
        'acquisition_price',
        'room_id',
        'employee_id',
        'condition',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'acquisition_year' => 'integer',
            'acquisition_price' => 'decimal:2',
            'condition' => ItemCondition::class,
            'status' => ItemStatus::class,
        ];
    }

    // Relationships

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function mutations(): HasMany
    {
        return $this->hasMany(ItemMutation::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(ItemInspection::class);
    }
}
