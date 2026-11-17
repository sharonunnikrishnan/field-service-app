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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('service_location_id')
                ->constrained('service_locations')
                ->cascadeOnDelete();

            $table->string('name', 150);
            $table->string('asset_code', 100);
            $table->string('asset_type', 100)->nullable();

            $table->string('manufacturer', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 150)->nullable();

            $table->date('installation_date')->nullable();

            $table->string('status', 20)
                ->default('active')
                ->index();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['company_id', 'asset_code'],
                'assets_company_asset_code_unique'
            );

            $table->index(
                ['company_id', 'customer_id'],
                'assets_company_customer_index'
            );

            $table->index(
                ['company_id', 'service_location_id'],
                'assets_company_location_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
