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
        Schema::create('good_records', function (Blueprint $table) {
            $table->id();
            $table->json('values')->nullable();
            $table->unsignedBigInteger('upload_id');
            $table->foreign('upload_id')->references('id')->on('file_uploads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_records');
    }
};
