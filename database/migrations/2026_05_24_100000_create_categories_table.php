<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->string('color')->nullable();
                $table->string('thumbnail_img')->nullable();
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('keywords')->nullable();
                $table->integer('sort_order')->default(0);
                $table->tinyInteger('featured')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('uid')->nullable();
                $table->timestamps();
            });
            return;
        }

        // Table exists — add any missing columns.
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'icon'))               $table->string('icon')->nullable();
            if (!Schema::hasColumn('categories', 'color'))              $table->string('color')->nullable();
            if (!Schema::hasColumn('categories', 'thumbnail_img'))      $table->string('thumbnail_img')->nullable();
            if (!Schema::hasColumn('categories', 'short_description'))  $table->text('short_description')->nullable();
            if (!Schema::hasColumn('categories', 'description'))        $table->longText('description')->nullable();
            if (!Schema::hasColumn('categories', 'meta_title'))         $table->string('meta_title')->nullable();
            if (!Schema::hasColumn('categories', 'meta_description'))   $table->text('meta_description')->nullable();
            if (!Schema::hasColumn('categories', 'keywords'))           $table->text('keywords')->nullable();
            if (!Schema::hasColumn('categories', 'sort_order'))         $table->integer('sort_order')->default(0);
            if (!Schema::hasColumn('categories', 'featured'))           $table->tinyInteger('featured')->default(0);
            if (!Schema::hasColumn('categories', 'status'))             $table->tinyInteger('status')->default(1);
            if (!Schema::hasColumn('categories', 'uid'))                $table->unsignedBigInteger('uid')->nullable();
        });
    }

    public function down(): void
    {
        // Do not drop — table may pre-date this migration.
    }
};
