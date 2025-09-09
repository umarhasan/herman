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
        Schema::table('mezuza_records', function (Blueprint $table) {
            $table->string('house_number')->nullable();
            $table->string('room_number')->nullable();
            $table->string('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('area_name')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->string('bought_from_phone_code')->nullable();
            $table->string('bought_from_phone_number')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mezuza_records', function (Blueprint $table) {
            $table->dropColumn([
                'house_number','room_number','street_number','street_name','area_name','city','country',
                'bought_from_phone_code','bought_from_phone_number'
            ]);
        });
    }
};
