<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_code', 100)->unique();
            $table->string('serial_number')->nullable()->index();
            $table->string('name')->index();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->year('acquisition_year')->nullable()->index();
            $table->decimal('acquisition_price', 15, 2)->nullable();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('condition', 20)->default('baik')->index();
            $table->string('status', 20)->default('aktif')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
