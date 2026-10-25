<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('services')) {
            return;
        }

        $pricingMigrationHasRun = Schema::hasTable(config('database.migrations.table', 'migrations'))
            && DB::table(config('database.migrations.table', 'migrations'))
                ->where('migration', '2026_10_07_234057_add_pricing_fields_to_services_table')
                ->exists();

        Schema::create('services', function (Blueprint $table) use ($pricingMigrationHasRun): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 150);
            $table->string('category', 30);
            $table->text('description');
            $table->string('status', 20)->default('Active');
            $table->text('inactive_reason')->nullable();
            $table->boolean('visible_in_dashboard')->default(true);

            if ($pricingMigrationHasRun) {
                $table->decimal('price', 10, 2)->nullable();
                $table->boolean('price_negotiable')->default(false);
                $table->string('price_note', 500)->nullable();
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // This recovery migration may have skipped an existing table, so it must not drop services.
    }
};
