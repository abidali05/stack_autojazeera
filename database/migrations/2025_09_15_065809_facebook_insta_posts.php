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
        Schema::create('facebook_insta_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('type')->comment('bike|car');
            $table->string('platform')->comment('facebook|instagram');
            $table->string('page_id')->nullable();
            $table->string('post_fbid')->nullable();
            $table->string('ig_media_id')->nullable();
            $table->timestamps();

            // indexes
            $table->index(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('facebook_insta_posts');
    }
};
