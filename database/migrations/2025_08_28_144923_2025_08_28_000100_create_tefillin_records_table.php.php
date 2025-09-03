<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tefillin_records', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable()->index();
            $table->enum('type',['head','arm'])->default('head'); // NEW
            $table->unsignedTinyInteger('parshe_number')->default(1); // 1..4
            $table->date('written_on')->nullable();
            $table->date('bought_on')->nullable();
            $table->string('bought_from')->nullable();
            $table->decimal('paid', 12, 2)->nullable();
            $table->string('inspected_by')->nullable();
            $table->date('inspected_on')->nullable();
            $table->date('next_due_date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->index(['user_id','type','parshe_number']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('tefillin_records');
    }
};