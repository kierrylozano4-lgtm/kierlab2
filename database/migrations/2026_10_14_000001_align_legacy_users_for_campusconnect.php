<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'full_name')) {
            if (Schema::hasColumn('users', 'name')) {
                Schema::table('users', function (Blueprint $table): void {
                    $table->renameColumn('name', 'full_name');
                });
            } else {
                Schema::table('users', function (Blueprint $table): void {
                    $table->string('full_name')->default('Campus member');
                });
            }
        }

        if (! Schema::hasColumn('users', 'student_id')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('student_id')->nullable()->unique();
            });
        }

        if (! Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->boolean('is_admin')->default(false);
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')
                ->where('role', 'Admin')
                ->update(['is_admin' => true]);
        }
    }

    public function down(): void
    {
        // Keep migrated account fields and role access intact during rollbacks.
    }
};
