<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Student relationship
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Appointment information
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->string('purpose');

            // Appointment status
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])
                ->default('Pending');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
