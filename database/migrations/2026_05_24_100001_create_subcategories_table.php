<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->string('thumbnail_img')->nullable();
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('keywords')->nullable();
                $table->integer('sort_order')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('uid')->nullable();
                $table->timestamps();
                $table->index(['category_id', 'status']);
            });
            return;
        }

        // Table exists — add any missing columns.
        Schema::table('subcategories', function (Blueprint $table) {
            if (!Schema::hasColumn('subcategories', 'category_id'))      $table->unsignedBigInteger('category_id')->nullable();
            if (!Schema::hasColumn('subcategories', 'icon'))             $table->string('icon')->nullable();
            if (!Schema::hasColumn('subcategories', 'thumbnail_img'))    $table->string('thumbnail_img')->nullable();
            if (!Schema::hasColumn('subcategories', 'short_description')) $table->text('short_description')->nullable();
            if (!Schema::hasColumn('subcategories', 'description'))      $table->longText('description')->nullable();
            if (!Schema::hasColumn('subcategories', 'meta_title'))       $table->string('meta_title')->nullable();
            if (!Schema::hasColumn('subcategories', 'meta_description')) $table->text('meta_description')->nullable();
            if (!Schema::hasColumn('subcategories', 'keywords'))         $table->text('keywords')->nullable();
            if (!Schema::hasColumn('subcategories', 'sort_order'))       $table->integer('sort_order')->default(0);
            if (!Schema::hasColumn('subcategories', 'status'))           $table->tinyInteger('status')->default(1);
            if (!Schema::hasColumn('subcategories', 'uid'))              $table->unsignedBigInteger('uid')->nullable();
        });
    }

    public function down(): void
    {
        // Do not drop — table may pre-date this migration.
    }
};
