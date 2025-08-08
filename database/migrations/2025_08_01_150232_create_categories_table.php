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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // bigint unsigned AUTO_INCREMENT primary key
            $table->string('name'); // varchar(255) not null
            $table->decimal('amount', 8, 2)->nullable(); // decimal(8,2) null
            $table->timestamps(); // created_at & updated_at nullable by default
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
