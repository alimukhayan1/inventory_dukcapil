<?php

namespace App\Models;

use App\Enums\MutationType;
use Database\Factories\ItemMutationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemMutation extends Model
{
    /** @use HasFactory<ItemMutationFactory> */
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'item_id',
        'mutation_type',
        'from_room_id',
        'to_room_id',
        'from_employee_id',
        'to_employee_id',
        'mutation_date',
        'description',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'mutation_type' => MutationType::class,
            'mutation_date' => 'date',
        ];
    }

    // Relationships

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function fromRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'from_room_id');
    }

    public function toRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'to_room_id');
    }

    public function fromEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'from_employee_id');
    }

    public function toEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'to_employee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
