<?php

namespace App\Models;

use App\Enums\ItemCondition;
use Database\Factories\ItemInspectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemInspection extends Model
{
    /** @use HasFactory<ItemInspectionFactory> */
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'item_id',
        'inspection_date',
        'is_found',
        'condition',
        'notes',
        'inspected_by',
    ];

    protected function casts(): array
    {
        return [
            'inspection_date' => 'date',
            'is_found' => 'boolean',
            'condition' => ItemCondition::class,
        ];
    }

    // Relationships

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspected_by');
    }
}
