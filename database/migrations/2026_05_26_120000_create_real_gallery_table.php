<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('gallery')) {
            Schema::create('gallery', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('photo')->nullable();
                $table->string('image_alt')->nullable();
                $table->text('tag_line')->nullable();
                $table->integer('position')->default(1);
                $table->tinyInteger('status')->default(1);
                $table->unsignedBigInteger('uid')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('gallery', function (Blueprint $table) {
                if (! Schema::hasColumn('gallery', 'name'))      $table->string('name');
                if (! Schema::hasColumn('gallery', 'photo'))     $table->string('photo')->nullable();
                if (! Schema::hasColumn('gallery', 'image_alt')) $table->string('image_alt')->nullable();
                if (! Schema::hasColumn('gallery', 'tag_line'))  $table->text('tag_line')->nullable();
                if (! Schema::hasColumn('gallery', 'position'))  $table->integer('position')->default(1);
                if (! Schema::hasColumn('gallery', 'status'))    $table->tinyInteger('status')->default(1);
                if (! Schema::hasColumn('gallery', 'uid'))       $table->unsignedBigInteger('uid')->nullable();
            });
        }

        Schema::dropIfExists('table_gallery');
    }

    public function down(): void
    {
        // Do not drop the gallery table on rollback — would lose data.
    }
};
