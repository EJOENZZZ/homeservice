<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialty');
            $table->string('badge')->default('VERIFIED');
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->unsignedInteger('jobs_count')->default(0);
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('must_change_password')->default(false);
            $table->string('verification_code')->nullable();
            $table->timestamp('verification_expires_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('years_experience')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};