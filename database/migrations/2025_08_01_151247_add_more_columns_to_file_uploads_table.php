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
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->string('title')->nullable()->after('path');
            $table->longText('author')->nullable()->after('title');
            $table->longText('testified')->nullable()->after('author');
            $table->string('amount')->nullable()->after('testified');
            $table->text('description')->nullable()->after('amount');
            $table->string('cover_image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'author',
                'testified',
                'amount',
                'description',
                'cover_image',
            ]);
        });
    }
};
