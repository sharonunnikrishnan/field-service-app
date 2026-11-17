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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('vendor_id')
                ->nullable()
                ->constrained('vendors')
                ->nullOnDelete();

            $table->foreignId('work_order_id')
                ->nullable()
                ->constrained('work_orders')
                ->nullOnDelete();

            $table->date('expense_date');

            $table->string('category', 100);

            $table->string('description', 255);

            $table->decimal('amount', 12, 2);

            $table->string('payment_method', 30);

            $table->string('reference', 100)
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'expense_date'],
                'expenses_company_date_index'
            );

            $table->index(
                ['company_id', 'category'],
                'expenses_company_category_index'
            );

            $table->index(
                ['company_id', 'vendor_id'],
                'expenses_company_vendor_index'
            );

            $table->index(
                ['company_id', 'work_order_id'],
                'expenses_company_work_order_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
