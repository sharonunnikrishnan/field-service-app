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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->restrictOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('po_number', 50);

            $table->date('order_date');
            $table->date('expected_date')->nullable();

            $table->string('status', 30)
                ->default('draft')
                ->index();

            $table->decimal('subtotal', 12, 2)
                ->default(0);

            $table->decimal('tax_amount', 12, 2)
                ->default(0);

            $table->decimal('discount_amount', 12, 2)
                ->default(0);

            $table->decimal('total_amount', 12, 2)
                ->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['company_id', 'po_number'],
                'purchase_orders_company_number_unique'
            );

            $table->index(
                ['company_id', 'vendor_id'],
                'purchase_orders_company_vendor_index'
            );

            $table->index(
                ['company_id', 'status'],
                'purchase_orders_company_status_index'
            );

            $table->index(
                ['company_id', 'order_date'],
                'purchase_orders_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
