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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dealershipName')->nullable();;
            $table->string('email')->unique()->nullable();
            $table->string('number')->unique()->nullable();
            $table->string('role')->default(0)->comment('0 for user and 1 for dealor 2 for dear_user');
            $table->string('package')->nullable();
            $table->string('firebase_uid')->nullable();
            
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('status')->default('inactive')->comment('active inactive and in review base status.');
            $table->string('google_id')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('dealer_id')->nullable();
            $table->string('website')->nullable();
            $table->string('permission')->nullable();
            $table->string('allow_company')->default(0);
            $table->string('bulk_import')->default(0)->comment('1 for allow company to upload bulk inventory');
            $table->string('user_management')->default(0)->comment('1 for allow to manage user management');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('otp')->after('remember_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
