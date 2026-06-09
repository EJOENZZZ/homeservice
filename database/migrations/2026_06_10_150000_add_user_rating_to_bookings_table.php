<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'user_rating')) {
                $table->unsignedTinyInteger('user_rating')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('bookings', 'user_review')) {
                $table->text('user_review')->nullable()->after('user_rating');
            }

            if (!Schema::hasColumn('bookings', 'rated_at')) {
                $table->timestamp('rated_at')->nullable()->after('user_review');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'rated_at')) {
                $table->dropColumn('rated_at');
            }

            if (Schema::hasColumn('bookings', 'user_review')) {
                $table->dropColumn('user_review');
            }

            if (Schema::hasColumn('bookings', 'user_rating')) {
                $table->dropColumn('user_rating');
            }
        });
    }
};