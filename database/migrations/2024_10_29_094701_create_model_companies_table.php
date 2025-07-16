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
        Schema::create('model_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->references('id')->on('make_companies')->onDelete('cascade');
            $table->string('bodytype');
            $table->string('name');
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_companies');
    }
};
