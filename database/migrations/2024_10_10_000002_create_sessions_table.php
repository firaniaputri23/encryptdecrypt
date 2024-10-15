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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID as primary key
            $table->foreignId('user_id')->nullable()->index(); // Foreign key referencing users, nullable
            $table->string('ip_address', 45)->nullable(); // User's IP address, allows IPv6
            $table->text('user_agent')->nullable(); // User agent string
            $table->longText('payload'); // Session payload data
            $table->integer('last_activity')->index(); // Timestamp of the last activity, indexed for performance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions'); // Drop sessions table if it exists
    }
};
