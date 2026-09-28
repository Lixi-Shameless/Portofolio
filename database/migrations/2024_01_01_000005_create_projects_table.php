<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('media_path')->nullable();   // uploaded image or video file (storage/app/public)
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('external_url')->nullable(); // link to live project / case study
            $table->string('tags')->nullable();          // comma-separated, e.g. "SQL, Power BI, Python"
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
