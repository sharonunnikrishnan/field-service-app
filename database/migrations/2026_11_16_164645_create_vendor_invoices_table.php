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
        Schema::create('vendor_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->restrictOnDelete();

            $table->foreignId('purchase_order_id')
                ->nullable()
                ->constrained('purchase_orders')
                ->nullOnDelete();

            $table->string('invoice_number', 50);

            $table->date('invoice_date');
            $table->date('due_date')->nullable();

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
                ['company_id', 'invoice_number'],
                'vendor_invoices_company_number_unique'
            );

            $table->index(
                ['company_id', 'vendor_id'],
                'vendor_invoices_company_vendor_index'
            );

            $table->index(
                ['company_id', 'purchase_order_id'],
                'vendor_invoices_company_po_index'
            );

            $table->index(
                ['company_id', 'status'],
                'vendor_invoices_company_status_index'
            );

            $table->index(
                ['company_id', 'invoice_date'],
                'vendor_invoices_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_invoices');
    }
};
