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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->cascadeOnDelete();

            $table->string('type', 30);

            $table->decimal('quantity', 12, 3);
            $table->decimal('unit_cost', 12, 2)->default(0);

            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->dateTime('transaction_date');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'inventory_item_id'],
                'inventory_transactions_company_item_index'
            );

            $table->index(
                ['company_id', 'type'],
                'inventory_transactions_company_type_index'
            );

            $table->index(
                ['reference_type', 'reference_id'],
                'inventory_transactions_reference_index'
            );

            $table->index(
                ['company_id', 'transaction_date'],
                'inventory_transactions_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
