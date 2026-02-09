<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manufacturer');
            $table->string('barcode')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('quantity_in_stock');
            $table->integer('min_quantity')->default(10);
            $table->text('description')->nullable();
            $table->string('prescription_required')->default(false);
            $table->string('image_path')->nullable();
            $table->date('expiry_date');
            $table->string('category');
            $table->string('active_substance');
            $table->decimal('dosage', 8, 2);
            $table->string('dosage_unit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
