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
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->restrictOnDelete();

            $table->date('payment_date');

            $table->decimal('amount', 12, 2);

            $table->string('payment_method', 30);

            $table->string('reference', 100)
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'customer_id'],
                'customer_payments_company_customer_index'
            );

            $table->index(
                ['company_id', 'invoice_id'],
                'customer_payments_company_invoice_index'
            );

            $table->index(
                ['company_id', 'payment_date'],
                'customer_payments_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_payments');
    }
};
