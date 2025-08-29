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
        Schema::create('facebook_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('dealer_id');
            $table->string('page_id');
            $table->longText('page_access_token');
            $table->string('type')->comment('dealer or admin')->default('dealer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_tokens');
    }
};
