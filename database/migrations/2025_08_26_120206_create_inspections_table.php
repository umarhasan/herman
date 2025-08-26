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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->enum('type', ['tefillin','mezuza']);
            $table->date('date_of_inspection');
            $table->date('next_inspection_date')->nullable();
            $table->string('inspector_name');
            $table->enum('status', ['pass','fail','repair_needed']);
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable(); // stored in storage/app/public/inspections
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
