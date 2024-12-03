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
        Schema::table('chirps', function (Blueprint $table) {
            // Modify the column to TEXT to support emojis
            $table->text('message')->change();  // Replace 'message' with your column name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chirps', function (Blueprint $table) {
            // Revert it back to string if necessary
            $table->string('message', 255)->change();  // Adjust the type if you want to revert
        });
    }
};
