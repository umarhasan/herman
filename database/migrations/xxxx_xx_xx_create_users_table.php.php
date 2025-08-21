<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Teacher specific fields
            $table->string('experience')->nullable()->after('email');
            $table->text('description')->nullable()->after('experience');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['experience', 'description', 'parent_id']);
        });
    }
};
