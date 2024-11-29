<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Add 'profile_picture' column to 'users' table after the 'bio' column
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('bio');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop 'profile_picture' column if the migration is rolled back
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }
};
