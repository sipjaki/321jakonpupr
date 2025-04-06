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
        Schema::create('tupoksis', function (Blueprint $table) {
            $table->id();
            $table->text('judul')->nullable();
            $table->text('keterangan')->nullable();

            $table->fullText(['judul', 'keterangan']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tupoksis');
    }
};
