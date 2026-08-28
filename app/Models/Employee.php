<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'employee_number',
        'position',
        'department',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function mutationsFrom(): HasMany
    {
        return $this->hasMany(ItemMutation::class, 'from_employee_id');
    }

    public function mutationsTo(): HasMany
    {
        return $this->hasMany(ItemMutation::class, 'to_employee_id');
    }
}
