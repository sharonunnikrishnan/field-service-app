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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->restrictOnDelete();

            $table->string('description', 255);

            $table->decimal('quantity', 12, 3)
                ->default(1);

            $table->decimal('unit_price', 12, 2)
                ->default(0);

            $table->decimal('tax_rate', 5, 2)
                ->default(0);

            $table->decimal('line_total', 12, 2)
                ->default(0);

            $table->timestamps();

            $table->index(
                ['purchase_order_id', 'inventory_item_id'],
                'purchase_order_items_po_inventory_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
