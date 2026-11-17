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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('service_location_id')
                ->constrained('service_locations')
                ->restrictOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();

            $table->foreignId('quotation_id')
                ->nullable()
                ->constrained('quotations')
                ->nullOnDelete();

            $table->foreignId('asset_id')
                ->nullable()
                ->constrained('assets')
                ->nullOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('title', 200);
            $table->text('description')->nullable();

            $table->string('priority', 20)
                ->default('normal')
                ->index();

            $table->string('status', 30)
                ->default('open')
                ->index();

            $table->dateTime('scheduled_start')->nullable();
            $table->dateTime('scheduled_end')->nullable();

            $table->dateTime('completed_at')->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'customer_id'],
                'work_orders_company_customer_index'
            );

            $table->index(
                ['company_id', 'status'],
                'work_orders_company_status_index'
            );

            $table->index(
                ['company_id', 'scheduled_start'],
                'work_orders_company_schedule_index'
            );

            $table->index(
                ['company_id', 'asset_id'],
                'work_orders_company_asset_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
