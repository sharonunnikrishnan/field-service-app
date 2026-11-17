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
        Schema::create('purchase_receiving_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_receiving_id')
                ->constrained('purchase_receivings')
                ->cascadeOnDelete();

            $table->foreignId('purchase_order_item_id')
                ->constrained('purchase_order_items')
                ->restrictOnDelete();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->restrictOnDelete();

            $table->decimal('quantity_received', 12, 3);

            $table->decimal('unit_cost', 12, 2)
                ->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['purchase_receiving_id', 'purchase_order_item_id'],
                'purchase_receiving_items_receiving_po_item_index'
            );

            $table->index(
                ['purchase_receiving_id', 'inventory_item_id'],
                'purchase_receiving_items_receiving_inventory_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receiving_items');
    }
};
