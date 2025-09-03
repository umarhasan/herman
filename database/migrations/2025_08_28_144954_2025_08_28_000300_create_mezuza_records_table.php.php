<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mezuza_records', function (Blueprint $table) {
            $table->id();
            $table->string('location'); // e.g. Main Door, Kitchen...
            $table->string('reference_no')->nullable();
            $table->date('written_on')->nullable();
            $table->string('bought_from')->nullable();
            $table->decimal('paid', 12, 2)->nullable();
            $table->string('inspected_by')->nullable();
            $table->date('inspected_on')->nullable();
            $table->date('next_due_date')->nullable();
            $table->date('reminder_email_on')->nullable();
            $table->string('condition')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mezuza_records');
    }
};
