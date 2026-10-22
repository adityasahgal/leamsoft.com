<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->string('meeting_link', 500)->nullable()->after('mode');
            $table->timestamp('client_notified_at')->nullable()->after('admin_note');
        });

        // "Google Meet" became the generic "Video call" mode
        DB::table('meetings')->where('mode', 'google_meet')->update(['mode' => 'video']);
    }

    public function down(): void
    {
        DB::table('meetings')->where('mode', 'video')->update(['mode' => 'google_meet']);

        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['meeting_link', 'client_notified_at']);
        });
    }
};
