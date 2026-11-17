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
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('work_order_id')
                ->constrained('work_orders')
                ->cascadeOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->date('report_date');

            $table->text('description')->nullable();
            $table->text('findings')->nullable();
            $table->text('work_performed')->nullable();
            $table->text('recommendations')->nullable();

            $table->string('status', 20)
                ->default('draft')
                ->index();

            $table->timestamps();

            $table->index(
                ['company_id', 'work_order_id'],
                'service_reports_company_work_order_index'
            );

            $table->index(
                ['company_id', 'report_date'],
                'service_reports_company_date_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
