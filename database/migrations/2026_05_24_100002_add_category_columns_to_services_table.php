<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('services', 'subcategory_id')) {
                $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('services', 'icon')) {
                $table->string('icon')->nullable()->after('image_alt');
            }
            if (!Schema::hasColumn('services', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('top');
            }

            $table->index(['category_id', 'status']);
            $table->index(['subcategory_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'status']);
            $table->dropIndex(['subcategory_id', 'status']);
            $table->dropColumn(['category_id', 'subcategory_id', 'icon', 'sort_order']);
        });
    }
};
