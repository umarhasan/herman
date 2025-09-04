<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tefillin_records', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('user_id'); // or wherever you like
        });
    }

    public function down()
    {
        Schema::table('tefillin_records', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};
