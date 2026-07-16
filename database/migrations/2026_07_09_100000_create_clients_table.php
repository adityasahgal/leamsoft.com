<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('designation')->nullable();
                $table->string('company')->nullable();
                $table->string('website')->nullable();
                $table->string('logo')->nullable();
                $table->string('image_alt')->nullable();
                $table->text('testimonial')->nullable();
                $table->integer('sort_order')->default(0);
                $table->tinyInteger('featured')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('uid')->nullable();
                $table->timestamps();
            });
            return;
        }

        // Table exists — add any missing columns.
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'designation'))  $table->string('designation')->nullable();
            if (!Schema::hasColumn('clients', 'company'))      $table->string('company')->nullable();
            if (!Schema::hasColumn('clients', 'website'))      $table->string('website')->nullable();
            if (!Schema::hasColumn('clients', 'logo'))         $table->string('logo')->nullable();
            if (!Schema::hasColumn('clients', 'image_alt'))    $table->string('image_alt')->nullable();
            if (!Schema::hasColumn('clients', 'testimonial'))  $table->text('testimonial')->nullable();
            if (!Schema::hasColumn('clients', 'sort_order'))   $table->integer('sort_order')->default(0);
            if (!Schema::hasColumn('clients', 'featured'))     $table->tinyInteger('featured')->default(0);
            if (!Schema::hasColumn('clients', 'status'))       $table->tinyInteger('status')->default(1);
            if (!Schema::hasColumn('clients', 'uid'))          $table->unsignedBigInteger('uid')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
