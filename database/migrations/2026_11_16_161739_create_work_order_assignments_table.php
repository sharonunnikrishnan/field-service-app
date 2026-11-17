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
        Schema::create('work_order_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('work_order_id')
                ->constrained('work_orders')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('scheduled_start')->nullable();
            $table->dateTime('scheduled_end')->nullable();

            $table->string('status', 20)
                ->default('assigned')
                ->index();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'work_order_id'],
                'work_order_assignments_company_work_order_index'
            );

            $table->index(
                ['company_id', 'user_id'],
                'work_order_assignments_company_user_index'
            );

            $table->index(
                ['company_id', 'scheduled_start'],
                'work_order_assignments_company_schedule_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_assignments');
    }
};
