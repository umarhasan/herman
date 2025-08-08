<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('file_category_file_upload', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_upload_id')->constrained()->onDelete('cascade');
            $table->string('file_path')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_category_file_upload');
    }
};