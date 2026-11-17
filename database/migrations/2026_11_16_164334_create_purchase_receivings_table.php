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
        Schema::create('purchase_receivings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->restrictOnDelete();

            $table->foreignId('received_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('receiving_number', 50);

            $table->date('received_date');

            $table->string('status', 30)
                ->default('received')
                ->index();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['company_id', 'receiving_number'],
                'purchase_receivings_company_number_unique'
            );

            $table->index(
                ['company_id', 'purchase_order_id'],
                'purchase_receivings_company_po_index'
            );

            $table->index(
                ['company_id', 'status'],
                'purchase_receivings_company_status_index'
            );

            $table->index(
                ['company_id', 'received_date'],
                'purchase_receivings_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receivings');
    }
};
