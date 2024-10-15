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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('username')->unique(); // Unique username
            $table->string('email')->unique(); // Unique email address
            $table->string('password'); // User password
            $table->longText('public_key'); // User's public key
            $table->longText('private_key'); // User's private key
            $table->boolean('doc_is_signed')->default(false); // Document signed status
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop the users table if it exists
    }
};
