<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->string('name', 150);
            $table->string('sku', 100);
            $table->string('unit', 30);

            $table->decimal('current_quantity', 12, 3)
                ->default(0);

            $table->decimal('minimum_quantity', 12, 3)
                ->default(0);

            $table->decimal('unit_cost', 12, 2)
                ->default(0);

            $table->string('status', 20)
                ->default('active')
                ->index();

            $table->timestamps();

            $table->unique(
                ['company_id', 'sku'],
                'inventory_items_company_sku_unique'
            );

            $table->index(
                ['company_id', 'status'],
                'inventory_items_company_status_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
