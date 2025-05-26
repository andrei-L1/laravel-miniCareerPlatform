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
        Schema::table('applications', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });

        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });

        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}; 