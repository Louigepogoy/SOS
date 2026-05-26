<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('email');
            $table->string('student_id')->nullable()->unique()->after('role');
            $table->string('course')->nullable()->after('student_id');
            $table->string('year_level')->nullable()->after('course');
            $table->string('phone')->nullable()->after('year_level');
            $table->string('avatar')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id', 'course', 'year_level', 'phone', 'avatar', 'is_active']);
        });
    }
};
