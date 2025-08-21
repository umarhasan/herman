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
        Schema::create('tefillin_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('side',['head','hand']); // head = 4 parts, hand = full box
            $table->enum('part_name',['A','B','C','D'])->nullable(); // null for hand
            $table->date('date_of_buy')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->enum('status',['active','removed'])->default('active');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tefillin_inspections');
    }
};
