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
        Schema::create('submitted_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('dealer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('friendFullname')->nullable();
            $table->string('friendemail')->nullable();
            $table->string('number')->nullable();
            $table->string('dob')->nullable();
            $table->string('apointment_time')->nullable();
            $table->string('perefered_contact_method')->nullable();
            $table->string('requesttype')->nullable();
            $table->longText('comment')->nullable();

            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_forms');
    }
};
