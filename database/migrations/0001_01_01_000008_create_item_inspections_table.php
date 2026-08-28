<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->date('inspection_date')->index();
            $table->boolean('is_found')->index();
            $table->string('condition', 20)->index();
            $table->text('notes')->nullable();
            $table->foreignId('inspected_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('created_at')->nullable();
            // No updated_at per ERD
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_inspections');
    }
};
