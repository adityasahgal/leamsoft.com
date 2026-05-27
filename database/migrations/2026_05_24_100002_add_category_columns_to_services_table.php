<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'category_id'))    $table->unsignedBigInteger('category_id')->nullable()->after('id');
            if (!Schema::hasColumn('services', 'subcategory_id')) $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            if (!Schema::hasColumn('services', 'icon'))           $table->string('icon')->nullable();
            if (!Schema::hasColumn('services', 'sort_order'))     $table->integer('sort_order')->default(0);
            if (!Schema::hasColumn('services', 'featured'))       $table->tinyInteger('featured')->default(0);
            if (!Schema::hasColumn('services', 'top'))            $table->tinyInteger('top')->default(0);
            if (!Schema::hasColumn('services', 'status'))         $table->tinyInteger('status')->default(1);
        });

        // Indexes — wrap in try/catch since checking existence reliably across DB drivers is awkward.
        try {
            Schema::table('services', function (Blueprint $table) {
                $table->index(['category_id', 'status'], 'services_category_id_status_index');
            });
        } catch (\Throwable $e) { /* index already exists */ }

        try {
            Schema::table('services', function (Blueprint $table) {
                $table->index(['subcategory_id', 'status'], 'services_subcategory_id_status_index');
            });
        } catch (\Throwable $e) { /* index already exists */ }
    }

    public function down(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        try { Schema::table('services', fn(Blueprint $t) => $t->dropIndex('services_category_id_status_index')); } catch (\Throwable $e) {}
        try { Schema::table('services', fn(Blueprint $t) => $t->dropIndex('services_subcategory_id_status_index')); } catch (\Throwable $e) {}

        Schema::table('services', function (Blueprint $table) {
            $cols = array_filter(['category_id', 'subcategory_id', 'icon', 'sort_order'], fn($c) => Schema::hasColumn('services', $c));
            if (!empty($cols)) $table->dropColumn($cols);
        });
    }
};
