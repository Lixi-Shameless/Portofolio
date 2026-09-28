<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable(); // stored path (storage/app/public)
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identities');
    }
};
