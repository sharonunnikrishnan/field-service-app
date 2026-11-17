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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('service_location_id')
                ->nullable()
                ->constrained('service_locations')
                ->nullOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('quotation_number', 50);

            $table->date('quotation_date');
            $table->date('valid_until')->nullable();

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
                ['company_id', 'quotation_number'],
                'quotations_company_number_unique'
            );

            $table->index(
                ['company_id', 'customer_id'],
                'quotations_company_customer_index'
            );

            $table->index(
                ['company_id', 'status'],
                'quotations_company_status_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
