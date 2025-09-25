<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add likes and views to threads
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
        });

        // Add likes and views to posts
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropColumn(['likes_count', 'views_count']);
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn(['likes_count', 'views_count']);
        });
    }
};