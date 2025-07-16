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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
          
            $table->foreignId('dealer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('condition');
            $table->string('assembly');
            $table->string('company_conection');
            $table->string('currency');
            $table->string('price');
            $table->string('negotiated_price')->nullable();
            $table->string('make');
            $table->string('model');
            $table->string('year');
            $table->string('milleage');
            $table->string('body_type')->nullable();;
            $table->string('doors');
            $table->string('fuel');
            $table->string('seating_capacity');
            $table->string('engine_capacity');
            $table->string('transmission');
            $table->string('drive_type');
            
            $table->string('exterior_color');
            $table->longText('dealer_comment')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
