<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promo_code_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_code_id')->constrained()->cascadeOnDelete();

            // Polymorphic: bisa Course atau Product
            // promotable_type = App\Models\Course atau App\Models\Product
            // promotable_id   = id dari course/product tersebut
            $table->morphs('promotable');

            $table->timestamps();

            // Satu promo tidak boleh assign item yang sama dua kali
            $table->unique(['promo_code_id', 'promotable_type', 'promotable_id'], 'promo_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_code_items');
    }
};
