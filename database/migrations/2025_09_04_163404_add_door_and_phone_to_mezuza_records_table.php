<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mezuza_records', function (Blueprint $table) {
            $table->string('door_description')->nullable();
            $table->string('bought_from_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mezuza_records', function (Blueprint $table) {
            //
        });
    }
};
