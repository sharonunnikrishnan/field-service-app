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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('work_order_id')
                ->nullable()
                ->constrained('work_orders')
                ->nullOnDelete();

            $table->foreignId('quotation_id')
                ->nullable()
                ->constrained('quotations')
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
                'invoices_company_number_unique'
            );

            $table->index(
                ['company_id', 'customer_id'],
                'invoices_company_customer_index'
            );

            $table->index(
                ['company_id', 'status'],
                'invoices_company_status_index'
            );

            $table->index(
                ['company_id', 'invoice_date'],
                'invoices_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
