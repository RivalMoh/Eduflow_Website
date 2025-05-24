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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id('postid');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->string('media_path')->nullable()->comment('Path to the attached media file (image/document)');
            $table->string('media_type')->nullable()->comment('Type of media (image/document)');
            $table->string('media_name')->nullable()->comment('Original name of the uploaded file');
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
