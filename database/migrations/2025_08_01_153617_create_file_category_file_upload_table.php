<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('file_category_file_upload', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('file_category_id')->nullable();
			$table->unsignedBigInteger('file_upload_id')->nullable();
			$table->foreign('file_category_id')->references('id')->on('file_category')->onDelete('set null');
			$table->foreign('file_upload_id')->references('id')->on('file_uploads')->onDelete('set null');
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