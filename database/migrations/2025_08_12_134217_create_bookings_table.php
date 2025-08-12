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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('topic')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('payment_link')->nullable();
            $table->string('payment_proof')->nullable(); // storage path
            $table->enum('status', [
                'awaiting_payment',
                'payment_link_sent',
                'payment_proof_uploaded',
                'payment_approved',
                'course_started',
                'recording_uploaded',
            ])->default('awaiting_payment');
            $table->string('zoom_meeting_id')->nullable();
            $table->text('zoom_join_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
