<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $table->string('cv_creative_path')->nullable()->after('photo');
            $table->string('cv_formal_path')->nullable()->after('cv_creative_path');
        });
    }

    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $table->dropColumn(['cv_creative_path', 'cv_formal_path']);
        });
    }
};
