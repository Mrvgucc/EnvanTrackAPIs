<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')
                ->constrained('categories');
            $table->foreignId('registered_personal')
                ->nullable()
                ->constrained('employees')
                ->onDelete('set null'); // ilgili calisan silindiginde demisrbas set null durumuna dusurulerek inactive yapilcak
            $table->enum('usage_status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};
