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
            // Add a nullable parent_chirp_id column to store the reference to the original chirp
            $table->foreignId('parent_chirp_id')
                  ->nullable() // Allow replies to have no parent
                  ->constrained('chirps') // Reference the chirps table itself
                  ->onDelete('cascade'); // If the parent chirp is deleted, the replies will also be deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chirps', function (Blueprint $table) {
            // Drop the parent_chirp_id column if the migration is rolled back
            $table->dropForeign(['parent_chirp_id']);
            $table->dropColumn('parent_chirp_id');
        });
    }
};
